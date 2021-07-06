<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\UnidadMedida;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* -----------------NUEVAS RUTAS : NO BORRAR------------------------ */
Route::get('/getComidas', function (Request $request) {
    $comidas = DB::table('comida as c')
					->join('tipocomida as tc','tc.TipoComidaId','c.TipoComidaId')
					->orderBy('ComidaNombre','asc')
					->where('ComidaEstado',1)
					->get();
	return response($comidas);
});
Route::get('/getHistorial', function (Request $request) {
    $historial = DB::table('historial')
					->where('HistorialEstado',1)
					->get();
	return Response::json($historial);
});
Route::get('/getRelevamiento/{id}', function ($id) {
    $relevamiento = DB::table('relevamientocomida as rc')
					->where('RelevamientoId',$id)
					->join('comida as c','c.ComidaId','rc.ComidaId')
					->get();
	$acompaniantes = 0 ;
	$relevamientosPorSala = DB::table('relevamientoporsala')
							->where('RelevamientoId',$id)
							->get();
	foreach ($relevamientosPorSala as $relevamientoPorSala) {
		$acompaniantes += $relevamientoPorSala->RelevamientoPorSalaAcompaniantes;
	}
	 
	$res = array(
		'comidas' =>$relevamiento,
		'acompaniantes'=> $acompaniantes
	);
	return response($res);
});
Route::get('/getMenuesPorTipo/{id}', function ($id) {
    $menuesPorTipo = DB::table('detallemenutipopaciente as dm')
					->where('MenuId',$id)
					->join('tipopaciente as tp','tp.TipoPacienteId','dm.TipoPacienteId')
					->get();
	return response($menuesPorTipo);
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
	
	// $relevamiento = DB::table('relevamiento')->where('RelevamientoId',$id)->first();
	// $detallesRelevamiento = DB::table('detallerelevamiento as dr')
	// 							->join('paciente as p','p.PacienteId','dr.PacienteId')
	// 							->join('persona as pe','pe.PersonaId','p.PersonaId')
	// 							->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
	// 							->join('cama as c','c.CamaId','dr.CamaId')
	// 							->join('pieza as pi','pi.PiezaId','c.PiezaId')
	// 							->join('sala as s','s.SalaId','pi.SalaId')
	// 							->join('empleado as e','e.EmpleadoId','dr.EmpleadoId')
	// 							->where('dr.RelevamientoId',$relevamiento->RelevamientoId)
	// 							->whereIn('DetalleRelevamientoId', function ($sub) use ($id) {
	// 								$sub->selectRaw('MAX(DetalleRelevamientoId)')->from('detallerelevamiento')->where('RelevamientoId',$id)->groupBy('PacienteId')->orderBy('updated_at')->orderBy('DetalleRelevamientoEstado'); // <---- la clave
	// 							})
	// 							->orderby('dr.DetalleRelevamientoId','desc')
	// 							->get();
	// foreach ($detallesRelevamiento as $detalleRelevamientoIndice => $detalleRelevamiento) {
	// 	$detalleRelevamiento->PacienteNombre = $detalleRelevamiento->PersonaApellido.', '.$detalleRelevamiento->PersonaNombre;
	// 	$detalleRelevamiento->SalaPiezaCamaNombre = $detalleRelevamiento->SalaNombre.'/'.$detalleRelevamiento->PiezaNombre.'/'.$detalleRelevamiento->CamaNumero;
	// 	$empleado= DB::table('empleado')->where('EmpleadoId',$detalleRelevamiento->EmpleadoId)->first();
	// 	$persona = DB::table('persona')->where('PersonaId',$empleado->PersonaId)->first();
	// 	$detalleRelevamiento->EmpleadoNombre = $persona->PersonaApellido.', '.$persona->PersonaNombre;
		// if($detalleRelevamiento->max != $detalleRelevamiento->DetalleRelevamientoId){
		// 	unset($detallesRelevamiento[$detalleRelevamientoIndice]);
		// }
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


