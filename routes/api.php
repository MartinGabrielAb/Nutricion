<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\UnidadMedida;


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
		$relevamiento[$tipoPaciente->TipoPacienteId] = [
			'id' => $tipoPaciente->TipoPacienteId,
			'nombre' => $tipoPaciente->TipoPacienteNombre,
			'cantidad' => 0
		];
	}
	$relevamientosPorSala = DB::table('relevamientoporsala')
							->where('RelevamientoId',$id)
							->where('RelevamientoPorSalaEstado',1)
							->get();
	foreach ($relevamientosPorSala as $relevamientoPorSala){
		$detallesRelevamiento = DB::table('detallerelevamiento')
								->where('RelevamientoPorSalaId',$relevamientoPorSala->RelevamientoPorSalaId)
								->where('DetalleRelevamientoEstado',1)
								->get();
		foreach($detallesRelevamiento as $detalle){
			//agrego si tiene acompañante y sumo el tipo de paciente
			$relevamiento[0]['cantidad'] += $detalle->DetalleRelevamientoAcompaniante;
			$relevamiento[$detalle->TipoPacienteId]['cantidad'] += 1 ;
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

Route::post('/saveTanda/{id}', function ($id, Request $request) {
	$observacion = $request['params']['observacion'];
	$comidas = $request['params']['comidas'];
	$temp_relev = DB::table('temp_relevamiento')
						->where('RelevamientoId',$id)
						->first();
	$temp_tanda = DB::table('temp_tanda')
					->where('TempRelevamientoId',$temp_relev->TempRelevamientoId)
					->orderBy('TandaNumero','desc')->first();
	$num_tanda = $temp_tanda->TandaNumero+1;
	$id_tanda = DB::table('temp_tanda')->insertGetId(
		[
			'TempRelevamientoId' => $temp_relev->TempRelevamientoId,
			'TandaNumero' => $num_tanda,
			'TandaObservacion' => $observacion,
		]
	);
	foreach ($comidas as $comida){
		//FALTA: DESCONTAR STOCK y congelador------------------------------------------------------
		DB::table('temp_comida')->insert(
			[
				'TempTandaId' => $id_tanda,
				'ComidaId' => $comida['id'],
				'CantidadNormal'=>$comida['cantidadNormal'],
				'CantidadCongelada'=>$comida['cantidadCongelador']
			]
		);
	}
	return true;
	
});

Route::post('/saveCongelador',function(Request $request){
	
});
Route::post('/finalizar/{id}',function($id){
	$comidas = array();
	$temp_relev = DB::table('temp_relevamiento as tr')
					->where('tr.RelevamientoId',$id)
					->first();
	$temp_tanda = DB::table('temp_tanda')
					->where('TempRelevamientoId',$temp_relev->TempRelevamientoId)
					->get();

	foreach($temp_tanda as $tanda){
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
	$historialId = DB::table('historial')->insertGetId(
		[	
			'RelevamientoId' => $id,
			'HistorialEstado'=>1
		]
	);
	foreach($comidas as $comida){
		DB::table('historialdetallecomida')->insert(
			[	
				'HistorialId' => $historialId,
				'ComidaNombre'=>$comida['nombre'],
				'Porciones' => $comida['cantidadNormal'],
				'Congelador' => $comida['cantidadCongelada']
			]
		);
	}
	DB::table('relevamiento')->where('RelevamientoId',$id)
							->update(['RelevamientoControlado' => 1]);
	return $historialId;
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
	try {
		$relevamientoAnt = $request['params']['relevamientoAnt'];
		$relevamientoNuevo = $request['params']['relevamientoNuevo'];
		$menuId = $request['params']['menu'];
		$relevamiento = DB::table('relevamiento')
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
			['TempRelevamientoId' => $tempRelevamientoId, 'TandaNumero' => 1]
		);
		foreach ($relevamientoAnt as $tipoPaciente){
			if($tipoPaciente['cantidad']>0){
				//Si el tipo de paciente es 0 es porque es un acompañante y le mando un tipo normal
				if($tipoPaciente['id'] == 0){
					$tipoNormal = DB::table('tipopaciente')
											->where('TipoPacienteNombre','Normal')
											->first();
					$tipoPaciente['id'] = $tipoNormal->TipoPacienteId;
				}
				$detalle = DB::table('detallemenutipopaciente')
								->where('MenuId',$menuId)
								->where('TipoPacienteId',$tipoPaciente['id'])
								->first();
				if($detalle != null){
					//HARDCODE TIPOSCOMIDA
					//SI ES RELEVAMIENTO DE LA MAÑANA TOMA SOLO LOS PRIMEROS TIPOS DE COMIDA
					if($relevamiento->RelevamientoTurno == 'Mañana'){
						$comidas = DB::table('comidaportipopaciente')
						->where('DetalleMenuTipoPacienteId',$detalle->DetalleMenuTipoPacienteId)
						->where('ComidaPorTipoPacientePrincipal',1)
						->where('TipoComidaId',1)
						->orWhere('TipoComidaId',2)
						->orWhere('TipoComidaId',3)
						->orWhere('TipoComidaId',4)
						->get();
					}else{
					//SI ES RELEVAMIENTO DE LA TARDE TOMA LOS OTROS TIPOS DE COMIDA(LA COLACION NO ES CONTEMPLADA)
						$comidas = DB::table('comidaportipopaciente')
						->where('DetalleMenuTipoPacienteId',$detalle->DetalleMenuTipoPacienteId)
						->where('ComidaPorTipoPacientePrincipal',1)
						->where('TipoComidaId',5)
						->orWhere('TipoComidaId',6)
						->orWhere('TipoComidaId',7)
						->orWhere('TipoComidaId',8)
						->get();
					}
					foreach($comidas as $comida){
						$tempComida = DB::table('temp_comida')
										->where('TempTandaId',$tempTandaId)
										->where('ComidaId',$comida->ComidaId)
										->first();
						if($tempComida==null){
							DB::table('temp_comida')->insert(
								[
									'TempTandaId' => $tempTandaId,
									'ComidaId' => $comida->ComidaId,
									'CantidadNormal'=>$tipoPaciente['cantidad']
								]
							);
						}else{
							DB::table('temp_comida')
									->where('TempTandaId', $tempTandaId)
									->where('ComidaId',$comida->ComidaId)
									->increment('CantidadNormal', $tipoPaciente['cantidad']);
						}
					}
				}
			}
		}
		return true;
	} catch (Exception $e) {
		return $e;
	}
});

Route::get('getMenu/{id}',function($id){
	$menu = DB::table('menu')
				->where('MenuId',$id)	
				->where('MenuEstado',1)
				->first();
	return response(array($menu));
});