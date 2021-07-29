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
Route::get('/getRelevamiento/{id}', function ($id) {
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
Route::get('/getComidasDeRelevamiento/{id}', function () {
	/*	{
			
			 id_comida : 
			 cantidad: 
		}
	*/
});
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
			if(empty($comidas[$temp_comida->ComidaId])){
				$comidas[$temp_comida->ComidaId] = array(
					'id' => $temp_comida->ComidaId,
					'nombre' => $temp_comida->ComidaNombre,
					'cantidadNormales' => $temp_comida->CantidadNormal,
					'cantidadCongeladas' => $temp_comida->CantidadCongelada
				);
			}else{
				$comidas[$temp_comida->ComidaId]['cantidadNormales'] += $temp_comida->CantidadNormal;
				$comidas[$temp_comida->ComidaId]['cantidadCongeladas'] += $temp_comida->CantidadCongelada;

			}
		}
	}
	return response($comidas);
});


Route::get('/getRelevamientosSinMenuAsignado', function () {
	$relevamientos = DB::table('relevamiento as r')
						->where('RelevamientoMenu',NULL)
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
		//Creo la tabla temporal para la primera vez con los datos del relevamiento anterior
		$tempRelevamientoId = DB::table('temp_relevamiento')->insertGetId(
			['RelevamientoId' => $relevamientoNuevo, 'MenuId' => $menuId]
		);
		$tempTandaId = DB::table('temp_tanda')->insertGetId(
			['TempRelevamientoId' => $tempRelevamientoId, 'TandaNumero' => 1]
		);
		foreach ($relevamientoAnt as $tipoPaciente){
			if($tipoPaciente['cantidad']>0){
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
					$comidas = DB::table('comidaportipopaciente')
								->where('DetalleMenuTipoPacienteId',$detalle->DetalleMenuTipoPacienteId)
								->where('ComidaPorTipoPacientePrincipal',1)
								->get();
	
					foreach($comidas as $comida){
						$tempComida = DB::table('temp_comida')
										->where('TempTandaId',$tempTandaId)
										->where('ComidaId',$comida->ComidaId)
										->first();
						if($tempComida==null){
							DB::table('temp_comida')->insert(
								['TempTandaId' => $tempTandaId,
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

