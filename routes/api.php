<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\UnidadMedida;
use App\Alimento;
use App\AlimentoPorProveedor;

use App\HistorialDetalleComida;
use App\HistorialDetalleAlimento;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* -----------------NUEVAS RUTAS : NO BORRAR------------------------ */
//Obtiene las comidas
Route::get('/getComidas', function (Request $request) {
    $comidas = DB::table('comida as c')
					->join('tipocomida as tc','tc.TipoComidaId','c.TipoComidaId')
					->orderBy('ComidaNombre','asc')
					->where('ComidaEstado',1)
					->get();
	return response($comidas);
});
//Obtiene el historial
Route::get('/getHistorial', function (Request $request) {
    $historial = DB::table('historial')
					->where('HistorialEstado',1)
					->get();
	return Response::json($historial);
});

//Retorna la cantidad relevada por tipo de paciente, en 0 esta la cantidad acompañantes
Route::get('/getRelevamientoPorMenu/{id}', function ($id) {
	$relevamiento = array();
	$tiposPaciente = DB::table('tipopaciente as tp')
						->where('TipoPacienteEstado',1)
						->get();
	$relevamiento[0] = ['id' => 0,'nombre' => "Acompañantes",'cantidad' => 0];
	foreach ($tiposPaciente as $tipoPaciente){
		//No creo los individuales
		if($tipoPaciente->TipoPacienteNombre != 'Individual'){
			$relevamiento[$tipoPaciente->TipoPacienteId] = [
				'id' => $tipoPaciente->TipoPacienteId,
				'nombre' => $tipoPaciente->TipoPacienteNombre,
				'cantidad' => 0
			];
		}
	}
	$relevamientosPorSala = DB::table('relevamientoporsala')
							->where('RelevamientoId',$id)
							->where('RelevamientoPorSalaEstado',1)
							->get();
	foreach ($relevamientosPorSala as $relevamientoPorSala){
		$detallesRelevamiento = DB::table('detallerelevamiento as dr')
								->where('RelevamientoPorSalaId',$relevamientoPorSala->RelevamientoPorSalaId)
								->where('DetalleRelevamientoEstado',1)
								->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
								->get();
		foreach($detallesRelevamiento as $detalle){
			//agrego si tiene acompañante y sumo el tipo de paciente
			$relevamiento[0]['cantidad'] += $detalle->DetalleRelevamientoAcompaniante;
			//Los individuales no los sumo
			if($detalle->TipoPacienteNombre != 'Individual'){
				$relevamiento[$detalle->TipoPacienteId]['cantidad'] += 1 ;
			}
		}
	}
	return response($relevamiento);
});
Route::get('/getRelevamientosAnteriores', function () {
		$relevamientosAnteriores = DB::table('relevamiento as r')
				->where('RelevamientoControlado',1)
				->where('RelevamientoEstado',1)
				->orderBy('RelevamientoFecha','ASC')
				->get();

		return response($relevamientosAnteriores);
});

//Retorna la cantidad de comidas de un relevamiento
Route::get('/getComidasDeRelevamiento/{id}', function ($id) {
	$comidas = array();
	$relevamientosPorSalas = DB::table('relevamientoporsala')
							->where('RelevamientoId',$id)
							->where('RelevamientoPorSalaEstado',1)	
							->get();
	foreach($relevamientosPorSalas as $relevamiento){
		$detallesRelevamiento = DB::table('detallerelevamiento')
						->where('RelevamientoPorSalaId',$relevamiento->RelevamientoPorSalaId)
						->get();
		foreach($detallesRelevamiento as $detalle){
			$detallesComidas = DB::table('detrelevamientoporcomida as dt')
									->where('DetalleRelevamientoId',$detalle->DetalleRelevamientoId)
									->join('comida as c','c.ComidaId','dt.ComidaId')
									->get(); 
			foreach ($detallesComidas as $detalleComida){
				$encontrado = -1;
				foreach($comidas as $index => $comida){
					if($detalleComida->ComidaId == $comida['id']){
						$encontrado = $index;
						break;
					}
				}
				if($encontrado==-1){
					array_push($comidas,[
						'id' => $detalleComida->ComidaId,
						'nombre' => $detalleComida->ComidaNombre,
						'cantidad' => 1,
					]);
				}else{
					$comidas[$encontrado]['cantidad'] += 1;
				}
			}						
		}
	}
	return $comidas;
});
Route::get('/getCongelador', function () {
	$congelador = DB::table('congelador as cg')
					->join('comida as c','c.ComidaId','cg.ComidaId')	
					->get();
	return response($congelador);
});

Route::post('/saveCongelador',function(Request $request){
	$comidas = $request['params']['comidas'];
	foreach($comidas as $comida){
		try {
			saveCongelador($comida['id'],$comida['porciones']);
		} catch (\Throwable $th) {

		}
	}
	return response(true);

});
function saveCongelador($id,$porciones){
	$existe = DB::table('congelador')
					->where('ComidaId',$id)
					->first();
	if($existe){	
		$affected = DB::table('congelador')
              ->where('CongeladorId',$existe->CongeladorId )
              ->update(['porciones' => $existe->Porciones+ $porciones]);
	}else{
		DB::table('congelador')->insert(
			[	'ComidaId' => $id,
				'Porciones'=>$porciones]
		);
		
	}
	

}
Route::get('/getComidasEnProgreso/{id}', function ($id) {

	
	$temp_relev = DB::table('temp_relevamiento as tr')
					->join('relevamiento as r','r.RelevamientoId','tr.RelevamientoId')
					->where('tr.RelevamientoId',$id)
					->first();
	$tandas = DB::table('temp_tanda')
					->where('TempRelevamientoId',$temp_relev->TempRelevamientoId)
					->get();
	$comidas = array();
	foreach($tandas as $tanda){
		$temp_comidas = DB::table('temp_comida as tc')
							->where('TempTandaId',$tanda->TempTandaId)
							->join('comida as c','c.ComidaId','tc.ComidaId')
							->get();
		foreach($temp_comidas as $temp_comida){
				$encontrado = -1;
				foreach($comidas as $index => $comida){
					if($temp_comida->ComidaId == $comida['id']){
						$encontrado = $index;
						break;
					}
				}
				if($encontrado==-1){
					array_push($comidas,[
						'id' => $temp_comida->ComidaId,
						'nombre' => $temp_comida->ComidaNombre,
						'cantidadNormal' => $temp_comida->CantidadNormal,
						'cantidadCongelada' => $temp_comida->CantidadCongelada
					]);
				}else{
					$comidas[$encontrado]['cantidadNormal'] += $temp_comida->CantidadNormal;
					$comidas[$encontrado]['cantidadCongelada'] += $temp_comida->CantidadCongelada;
				}
		}
	}
	return response($comidas);
});

Route::get('/getTandasRelevamiento/{id}', function ($id) {
	$temp_relev = DB::table('temp_relevamiento as tr')
					->join('relevamiento as r','r.RelevamientoId','tr.RelevamientoId')
					->where('tr.RelevamientoId',$id)
					->first();
	$temp_tandas = DB::table('temp_tanda')
					->where('TempRelevamientoId',$temp_relev->TempRelevamientoId)
					->get();
	$tandas = array();
	foreach($temp_tandas as $temp_tanda){
		$comidas = array();
		$temp_comidas = DB::table('temp_comida as tc')
							->where('TempTandaId',$temp_tanda->TempTandaId)
							->join('comida as c','c.ComidaId','tc.ComidaId')
							->get();
		foreach($temp_comidas as $temp_comida){
				$encontrado = -1;
				foreach($comidas as $index => $comida){
					if($temp_comida->ComidaId == $comida['id']){
						$encontrado = $index;
						break;
					}
				}
				if($encontrado==-1){
					array_push($comidas,[
						'id' => $temp_comida->ComidaId,
						'nombre' => $temp_comida->ComidaNombre,
						'cantidadNormal' => $temp_comida->CantidadNormal,
						'cantidadCongelada' => $temp_comida->CantidadCongelada
					]);
				}else{
					$comidas[$encontrado]['cantidadNormal'] += $temp_comida->CantidadNormal;
					$comidas[$encontrado]['cantidadCongelada'] += $temp_comida->CantidadCongelada;
				}
		}
		array_push($tandas,[
			'id' => $temp_tanda->TempTandaId,
			'numero' => $temp_tanda->TandaNumero,
			'observacion' => $temp_tanda->TandaObservacion,
			'hora' =>$temp_tanda->TandaHora,
			'comidas' => $comidas,
		]);
	} 
	return response($tandas);
});


Route::post('/finalizar/{id}',function($id){
	DB::table('relevamiento')->where('RelevamientoId',$id)
							->update(['RelevamientoControlado' => 1]);
	$historial = DB::table('historial')->where('RelevamientoId',$id)->first();
	return $historial->HistorialId;
});

Route::get('/getRelevamientosSinMenuAsignado', function () {
	$relevamientos = DB::table('relevamiento as r')
						->where('RelevamientoMenu',NULL)
						->where('RelevamientoControlado',0)
						->where('RelevamientoEstado',1)
						->get();
	return response($relevamientos);
});
Route::get('/getMenues', function () {
	$menues = DB::table('menu as m')
						->where('MenuEstado',1)
						->get();
	return response($menues);
});
//Retorno el menu y sus detalles por tipo y cada uno con sus comidas
Route::get('/getMenu/{id}', function ($id) {
    $menu = DB::table('menu as m')
					->where('MenuId',$id)
					->first();
	$detalles = DB::table('detallemenutipopaciente as dm')
					->join('tipopaciente as tp','tp.TipoPacienteId','dm.TipoPacienteId')
					->get();
	$det = array();
	foreach ($detalles as $detalle){
		$comidas = DB::table('comidaportipopaciente as ct')
					->where('DetalleMenuTipoPacienteId',$detalle->DetalleMenuTipoPacienteId)
					->join('comida as com','com.ComidaId','ct.ComidaId')	
					->get();
		array_push($det,array(
			'id' => $detalle->DetalleMenuTipoPacienteId,
			'tipo' => $detalle->TipoPacienteNombre,
			'comidas' =>$comidas,
		));	
	}
	$respuesta = array (
		'id' => $menu->MenuId,
		'nombre' => $menu->MenuNombre,
		'detalles' => $det,
	);
	return response($respuesta);
});
Route::get('/getComidasDeMenu/{id}', function ($id) {
    $comidas = DB::table('comidaportipopaciente as ctp')
					->where('DetalleMenuTipoPacienteId',$id)
					->join('comida as c','c.ComidaId','ctp.ComidaId')
					->orderBy('c.ComidaNombre','asc')
					->get();
	return response($comidas);
});

/* -----------------Obtengo los nutrienes---------------------- -*/
Route::get('getNutrientes',function(Request $request){
	$id = $request['id'];
	$menu = DB::table('detallemenutipopaciente')
					->where('DetalleMenuTipoPacienteId',$id)
					->first();
	
	$comidasPorTipoPaciente = DB::table('comidaportipopaciente as c')
					->join('TipoComida as t','t.TipoComidaId','c.TipoComidaId')
					->where('DetalleMenuTipoPacienteId', $menu->DetalleMenuTipoPacienteId)
					->get();
	$comidas = array();
	foreach ($comidasPorTipoPaciente as $comidaPorTipoPaciente) {

		$alimentosPorComida = DB::table('alimentoporcomida as a')
						->join('Alimento as alim','alim.AlimentoId','a.AlimentoId')
						->where('ComidaId',$comidaPorTipoPaciente->ComidaId)
						->get();
		$alimentos=array();
		foreach ($alimentosPorComida as $alimentoPorComida) {
			$nutrientesPorAlimento = DB::table('nutrienteporalimento')
						->where('AlimentoId',$alimentoPorComida->AlimentoId)
						->get();
			$nutrientes = array();
			$unidadMedida = UnidadMedida::findOrFail($alimentoPorComida->UnidadMedidaId);
			if($unidadMedida->UnidadMedidaNombre == 'Unidad' ) {
				foreach ($nutrientesPorAlimento as $nutrientePorAlimento) {
					array_push($nutrientes, $nutrientePorAlimento->NutrientePorAlimentoValor * $alimentoPorComida->AlimentoPorComidaCantidadNeto);
				}
			}else{
				foreach ($nutrientesPorAlimento as $nutrientePorAlimento) {
					array_push($nutrientes, $nutrientePorAlimento->NutrientePorAlimentoValor/100 * $alimentoPorComida->AlimentoPorComidaCantidadNeto);
				}
			}
			$alimento = array('cantidadAlimento' => $alimentoPorComida->AlimentoPorComidaCantidadNeto,
								'nombreAlimento'=> $alimentoPorComida->AlimentoNombre,
								  'nutrientes'=>$nutrientes);
			array_push($alimentos, $alimento);
		}
		$comida = array('nombreComida'=>$comidaPorTipoPaciente->TipoComidaNombre,
						'alimentos'   => $alimentos);
		array_push($comidas,$comida);
	}
	return ($comidas);
});
/* -----------------verificación de existencia: NUTRIENTES DE ALIMENTOS AL ASIGNAR ALIMENTO A COMIDA ---------------------- -*/
Route::get('nutrientesPorAlimento/{id}',function($id){
	$nutrientes = DB::table('nutriente')->get();
	$nutrientesPorAlimentos = DB::table('nutrienteporalimento')->where('AlimentoId',$id)->get();

	if(count($nutrientes) == count($nutrientesPorAlimentos)){
		$resultado = 1;
	}elseif(count($nutrientes) != count($nutrientesPorAlimentos)){
		$resultado = 2;
	}else{
		$resultado = false;
	}
	return $resultado;
});
/* -----------------DETALLES DE RELEVAMIENTO ---------------------- -*/
Route::get('relevamientos/{id}',function($id){
	$detallesRelevamiento = DB::table('detallerelevamiento')
								->where('RelevamientoId',$id)
								->whereIn('DetalleRelevamientoId', function ($sub) use ($id) {
									$sub->selectRaw('MAX(DetalleRelevamientoId)')->from('detallerelevamiento')->where('RelevamientoId',$id)->groupBy('PacienteId')->orderBy('updated_at')->orderBy('DetalleRelevamientoEstado'); // <---- la clave
								})
								->orderby('DetalleRelevamientoId','desc')
								->get();

	return DataTables::of($detallesRelevamiento)
						->addColumn('PacienteNombre',function($detalleRelevamiento){
							$paciente = DB::table('paciente')
												->where('PacienteId',$detalleRelevamiento->PacienteId)
												->first();
							$persona = DB::table('persona')
											->where('PersonaId',$paciente->PersonaId)
											->first();
							return $persona->PersonaApellido.", ".$persona->PersonaNombre;
						})
						->addColumn('TipoPacienteNombre',function($detalleRelevamiento){
							$tipoPaciente = DB::table('tipopaciente')
												->where('TipoPacienteId',$detalleRelevamiento->TipoPacienteId)
												->first();
							return $tipoPaciente->TipoPacienteNombre;
						})
						->addColumn('SalaPiezaCamaNombre',function($detalleRelevamiento){
							$cama = DB::table('cama')
												->where('CamaId',$detalleRelevamiento->CamaId)
												->first();
							$pieza = DB::table('pieza')
												->where('PiezaId',$cama->PiezaId)
												->first();
							$sala = DB::table('sala')
												->where('SalaId',$pieza->SalaId)
												->first();

							return $sala->SalaNombre."/".$pieza->PiezaNombre."/".$cama->CamaNumero;
						})
						->addColumn('DetalleRelevamientoEstado',function($detalleRelevamiento){
							if ($detalleRelevamiento->DetalleRelevamientoEstado == 1) {
								return '<td><p class="text-success">Activo</p></td>';
							}else{
								return '<td><p class="text-danger">Inactivo</p></td>';
							}
						})
						->addColumn('Relevador',function($detalleRelevamiento){
							$usuario = DB::table('users')
												->where('id',$detalleRelevamiento->UserId)
												->first();
						
							return $usuario->name;
						})
						->addColumn('DetalleRelevamientoAcompaniante',function($detalleRelevamiento){
							if ($detalleRelevamiento->DetalleRelevamientoAcompaniante == 1) {
								return '<td><p class="text-success">Si</p></td>';
							}else{
								return '<td><p class="text-danger">No</p></td>';
							}
						})
						->addColumn('btn','relevamientos/actionsDetalleRelevamiento')
	 					->rawColumns(['btn','DetalleRelevamientoEstado','DetalleRelevamientoAcompaniante'])
	 					->toJson();
});
/* -----------------Ultimo relevamiento de pacienteId ---------------------- -*/
Route::get('detallesrelevamiento/{id}',function($id){
	$persona = DB::table('persona')->where('PersonaCuil',$id)->first();
	$paciente = DB::table('paciente')->where('PersonaId',$persona->PersonaId)->first();
	$detalleRelevamiento = DB::table('detallerelevamiento as dr')
							->where('PacienteId',$paciente->PacienteId)
							->whereIn('DetalleRelevamientoId', function ($sub){
								$sub->selectRaw('MAX(DetalleRelevamientoId)')->from('detallerelevamiento')->groupBy('PacienteId')->orderBy('updated_at')->orderBy('DetalleRelevamientoEstado'); // <---- la clave
							})
							->orderby('dr.DetalleRelevamientoId','desc')
							->first();
	return compact('detalleRelevamiento');
});
/* -----------------Historial ---------------------- -*/

Route::get('historial',function(){
	$historial = DB::table('historial')->where('HistorialEstado',1)->get();
	return DataTables::of($historial)
						->addColumn('btn','historial/actions')
	 					->rawColumns(['btn'])
	 					->toJson();
});
Route::post('seleccionarMenu',function(Request $request){
	//relevamientoAnt = [ {id,nombre,cantidad}]
	//relevamientoNuevo = ID
	try {
		$relevamientoAnt = $request['params']['relevamientoAnt'];
		$relevamientoNuevo = $request['params']['relevamientoNuevo'];
		$menuId = $request['params']['menu'];
		DB::beginTransaction();
		$noHabiaStock = array();
		//creo el nuevo historial
		$historialId = DB::table('historial')->insertGetId(
			['RelevamientoId' => $relevamientoNuevo]
		);
		DB::table('relevamiento')
				->where('RelevamientoId',$relevamientoNuevo)
				->update(['RelevamientoMenu' => $menuId]);
		$relevamiento =  DB::table('relevamiento')
								->where('RelevamientoId',$relevamientoNuevo)
								->first();
		//Creo la tabla temporal para la primera vez con los datos del relevamiento anterior
		$tempRelevamientoId = DB::table('temp_relevamiento')->insertGetId(
			['RelevamientoId' => $relevamientoNuevo, 'MenuId' => $menuId]
		);
		$tempTandaId = DB::table('temp_tanda')->insertGetId(
			['TempRelevamientoId' => $tempRelevamientoId, 'TandaNumero' => 1,'TandaObservacion' => 'Tanda inicial']
		);
		foreach ($relevamientoAnt as $tipoPaciente){
			if($tipoPaciente['cantidad']>0){
				//Si el tipo de paciente es 0 es porque es un acompañante y le mando un tipo normal
				if($tipoPaciente['id'] == 0){
					$tipoNormal = DB::table('tipopaciente')
											->where('TipoPacienteNombre','Normal')
											->first();
					$tipoPaciente['nombre'] = $tipoNormal->TipoPacienteNombre;
					$tipoPaciente['id'] = $tipoNormal->TipoPacienteId;
				}
				$detalle = DB::table('detallemenutipopaciente')
								->where('MenuId',$menuId)
								->where('TipoPacienteId',$tipoPaciente['id'])
								->first();
				if($detalle != null){
					//SI ES RELEVAMIENTO DE LA MAÑANA TOMA SOLO LOS PRIMEROS TIPOS DE COMIDA
					if($relevamiento->RelevamientoTurno == 'Mañana'){
						$comidas = DB::table('comidaportipopaciente as ctp')
						->where('DetalleMenuTipoPacienteId',$detalle->DetalleMenuTipoPacienteId)
						->join('comida as com','ctp.ComidaId','com.ComidaId')
						->join('tipocomida as tc','tc.TipoComidaId','com.TipoComidaId')
						->where('ComidaPorTipoPacientePrincipal',1)
						->where('com.TipoComidaTurno',0)
						->get();
					}else{
					//SI ES RELEVAMIENTO DE LA TARDE TOMA LOS OTROS TIPOS DE COMIDA(LA COLACION NO ES CONTEMPLADA)
						$comidas = DB::table('comidaportipopaciente as ctp')
							->where('DetalleMenuTipoPacienteId',$detalle->DetalleMenuTipoPacienteId)
							->where('ComidaPorTipoPacientePrincipal',1)
							->join('comida as com','ctp.ComidaId','com.ComidaId')
							->join('tipocomida as tc','tc.TipoComidaId','com.TipoComidaId')
							->where('com.TipoComidaTurno',1)
							->get();
					}
					foreach($comidas as $comida){	
						$alcanzo = guardarComida($comida,$tipoPaciente['cantidad'],$historialId,$tempTandaId);
						if(!$alcanzo) {
							array_push($noHabiaStock,$tipoPaciente);
							break;
						}
					}
				}
			}
		}
		if(count($noHabiaStock) == 0){
			DB::commit();
			return true;							
		}else{
			DB::rollback();
			return response()->json(['error'=>$noHabiaStock]);;
		}
	} catch (Exception $e) {
		return $e;
	}
});
Route::post('/saveTanda/{id}', function ($id, Request $request) {
	$observacion = $request['params']['observacion'];
	$comidas = $request['params']['comidas'];
	$paraPersonal = $request['params']['paraPersonal'];
	if($paraPersonal) $observacion = '(PARA PERSONAL)'.$observacion;
	DB::beginTransaction();
	$noHabiaStock = array();
	$historial = DB::table('historial')
					->where('RelevamientoId',$id)
					->first();
	$temp_relev = DB::table('temp_relevamiento')
						->where('RelevamientoId',$id)
						->first();
	$temp_tanda = DB::table('temp_tanda')
					->where('TempRelevamientoId',$temp_relev->TempRelevamientoId)
					->orderBy('TandaNumero','desc')->first();
	$num_tanda = $temp_tanda->TandaNumero+1;
	$id_tanda = DB::table('temp_tanda')->insertGetId([
			'TempRelevamientoId' => $temp_relev->TempRelevamientoId,
			'TandaNumero' => $num_tanda,
			'TandaObservacion' => $observacion,
		]
	);
	foreach ($comidas as $comida){
		$comida_aux = DB::table('comida')->where('ComidaId',$comida['id'])->first();
		$comida['nombre'] = $comida_aux->ComidaNombre;
		$alcanzo = guardarComida($comida_aux,$comida['cantidadNormal'],$historial->HistorialId,$id_tanda,$paraPersonal);
		if(!$alcanzo) {
			array_push($noHabiaStock,$comida);
			break;
		}
	}
	if(count($noHabiaStock) == 0){
		DB::commit();
		return true;							
	}else{
		DB::rollback();
		return response()->json(['error'=>$noHabiaStock]);;
	}
});

Route::get('getMenu/{id}',function($id){
	$menu = DB::table('menu')
				->where('MenuId',$id)	
				->where('MenuEstado',1)
				->first();
	return response(array($menu));
});

 //retorna true si se pudo guardar y el stock alcanzaba
function guardarComida($comida , $porciones,$historialId,$tempTandaId,$paraPersonal){
	$bitPersonal = 0;
	if($paraPersonal) $bitPersonal = 1;
	$alimentos = descontarStock($comida->ComidaId,$porciones);
	if($alimentos == false) return false;
	//Si se pudo descontarStock correctamente lo guardo en el historial
	$historialDetComida = DB::table('historialdetallecomida')
			->where('HistorialId',$historialId)
			->where('ComidaId', $comida->ComidaId)
			->where('ParaPersonal',$bitPersonal)
			->first();
	if($historialDetComida){
		DB::table('historialdetallecomida')
				->where('HistorialId',$historialId)
				->where('ComidaId',$comida->ComidaId)
				->where('ParaPersonal',$bitPersonal)
				->increment('Porciones',$porciones);
		$tempComida = DB::table('temp_comida')
					->where('TempTandaId',$tempTandaId)
					->where('ComidaId',$comida->ComidaId)
					->first();
		DB::table('temp_comida')
				->where('TempTandaId', $tempTandaId)
				->where('ComidaId',$comida->ComidaId)
				->increment('CantidadNormal', $porciones);
		foreach($alimentos as $alimento){
				$historialDetAlimento = HistorialDetalleAlimento::
										where('HistorialDetalleComidaId',$historialDetComida->HistorialDetalleComidaId)
										->where('AlimentoId', $alimento['id'])
										->first();
				$historialDetAlimento->CostoTotal += $alimento['costo'];
				$historialDetAlimento->update();
		}
	}else{
		$historialDetComida = new HistorialDetalleComida();
		$historialDetComida->HistorialId = $historialId;
		$historialDetComida->ComidaId = $comida->ComidaId; 
		$historialDetComida->ComidaNombre = $comida->ComidaNombre; 
		$historialDetComida->Porciones = $porciones;
		$historialDetComida->ParaPersonal = $bitPersonal;
		$historialDetComida->save();
		$temp_comida = DB::table('temp_comida')->insertGetId([
			'TempTandaId' => $tempTandaId,
			'ComidaId' => $comida->ComidaId,
			'CantidadNormal'=>$porciones
		]);
		foreach($alimentos as $alimento){
			$historialDetAlimento = new HistorialDetalleAlimento();
			$historialDetAlimento->HistorialDetalleComidaId = $historialDetComida->HistorialDetalleComidaId;
			$historialDetAlimento->AlimentoId = $alimento['id'];
			$historialDetAlimento->AlimentoNombre = $alimento['alimento'];
			$historialDetAlimento->UnidadMedida = $alimento['unidadMedida'];
			$historialDetAlimento->Cantidad = $alimento['cantidad'];
			$historialDetAlimento->CostoTotal = $alimento['costo'];
			$historialDetAlimento->save();
		}
	}


	//Si ya existe solamente incremento las porciones,descuento el stock y
	//no guardo los alimentos xq estos se guardan una sola vez pero si aumento los costos xq son distintos
	//cada vez que descuento del stock
	return true;	
}
//retorna false si no alcanzo el stock, sino devuelve un array de con los alimentos y sus costos
function descontarStock($comidaId,$porciones){
	$costos = array();
	$alimentosPorComida = DB::table('alimentoporcomida as apc')
							->where('ComidaId',$comidaId)
							->join('alimento as a','a.AlimentoId','apc.AlimentoId')
							->join('unidadmedida as u','u.UnidadMedidaId','apc.UnidadMedidaId')
							->where('AlimentoPorComidaEstado',1)
							->get();
	foreach($alimentosPorComida as $alimentoPorComida){
		$alimento = Alimento::where('AlimentoId',$alimentoPorComida->AlimentoId)
							->where('AlimentoEstado',1)
							->join('unidadmedida as u','u.UnidadMedidaId','alimento.UnidadMedidaId')
							->first();
		//Controlo la unidad de medida
		if($alimentoPorComida->UnidadMedidaId == $alimento->UnidadMedidaId || $alimento->UnidadMedidaNombre == 'Unidad'){
			$cantidad = $alimentoPorComida->AlimentoPorComidaCantidadNeto * $porciones;
		}else{
			$cantidad = $alimentoPorComida->AlimentoPorComidaCantidadBruta/1000 * $porciones;
		}
		//Si no alcanza pongo el stock en 0 (para que las comidas siguientes no cuenten con este alimento,el rollback lo va a volver a su estado anterior)
		if($cantidad > $alimento->AlimentoCantidadTotal){                                           
			$alimento->AlimentoCantidadTotal = 0; 
			$alimento->update();                    
			return false;
		}//Si alcanza hago la logica para restar de manera correcta de alimentoporproveedor
		else{
			$alimentoPorProveedor = AlimentoPorProveedor::where('AlimentoId',$alimento->AlimentoId)
										->orderBy('AlimentoPorProveedorVencimiento','ASC')
										->get();
			$costo = 0;
			foreach($alimentoPorProveedor as $alimentoPorProveedor){
				if($cantidad == 0){
					break;
				}
				$disponible = $alimentoPorProveedor->AlimentoPorProveedorCantidad-$alimentoPorProveedor->AlimentoPorProveedorCantidadUsada;
				$diferencia = $cantidad - $disponible;
				//Si es mayor a 0 es porque no me alcanzo lo de ese proveedor
				if($diferencia>=0){
					$costo += $disponible * $alimentoPorProveedor->AlimentoPorProveedorCosto;
					$alimento->AlimentoCantidadTotal -= $disponible;
					$cantidad = $diferencia;
					$alimentoPorProveedor->AlimentoPorProveedorCantidadUsada += $disponible;
					$alimentoPorProveedor->AlimentoPorProveedorEstado = 0;
				}else{
					$costo += $cantidad * $alimentoPorProveedor->AlimentoPorProveedorCosto;
					$alimento->AlimentoCantidadTotal -=$cantidad;
					$alimentoPorProveedor->AlimentoPorProveedorCantidadUsada += $cantidad;
					$cantidad = 0;
				}
				$alimentoPorProveedor->update();
				$alimento->update();
			}
			array_push($costos, [
				'id' => $alimento->AlimentoId,
				'alimento' =>$alimento->AlimentoNombre,
				'unidadMedida' => $alimentoPorComida->UnidadMedidaNombre,
				'cantidad' => $alimentoPorComida->AlimentoPorComidaCantidadNeto,
				'costo' => $costo,
			]);	
		}
	} 
	return $costos;	
}