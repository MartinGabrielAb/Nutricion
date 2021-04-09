<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\UnidadMedida;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/* -----------------Menues Normales ---------------------- -*/

Route::get('menues',function(){
	$menues = DB::table('menu')->where('MenuEstado',1)
								->where('MenuParticular',0)
								->get();
	return DataTables::of($menues)
						->addColumn('MenuCostoTotal',function($menu){
								return "$".$menu->MenuCostoTotal;
							})				
						->addColumn('btn','menues/actions/menuesActions')
	 					->rawColumns(['btn'])
	 					->toJson();
});
/* -----------------Menues Particulares ---------------------- -*/

Route::get('particulares',function(){
	$menues = DB::table('menu')->where('MenuEstado',1)
								->where('MenuParticular',1)
								->get();
	return DataTables::of($menues)
						->addColumn('MenuCostoTotal',function($menu){
								return "$".$menu->MenuCostoTotal;
							})		
						->addColumn('btn','menues/actions/particularesActions')
	 					->rawColumns(['btn'])
	 					->toJson();
});

/* -----------------MENU POR TIPO PACIENTE---------------------- -*/

Route::get('menuTipo',function(Request $request){
	$id = $request['id'];
	$menues = DB::table('detallemenutipopaciente')
								->where('MenuId',$id)
								->get();

	return DataTables::of($menues)
						->addColumn('TipoPaciente',function($menu){
							$tipoPaciente = DB::table('tipopaciente')
												->where('TipoPacienteId',$menu->TipoPacienteId)
												->first();
							return $tipoPaciente->TipoPacienteNombre;
						})
						->addColumn('DetalleMenuTipoPacienteCostoTotal',function($menu){
								return "$".$menu->DetalleMenuTipoPacienteCostoTotal;
							})
						->addColumn('btn','menues/actions/menuTipoActions')
	 					->rawColumns(['btn'])
	 					->toJson();
});
/* -----------------Comidas por tipo paciente---------------------- -*/

Route::get('comidasPorTipoPaciente',function(Request $request){
	$id = $request['id'];
	$comidas = DB::table('comidaportipopaciente')
								->where('DetalleMenuTipoPacienteId',$id)
								->get();
	return DataTables::of($comidas)
						->addColumn('TipoComida',function($comida){
							$tipoComida = DB::table('tipocomida')
												->where('TipoComidaId',$comida->TipoComidaId)
												->first();
							return $tipoComida->TipoComidaNombre;
						})
						->addColumn('ComidaId',function($comida){
							$comida = DB::table('comida')
												->where('ComidaId',$comida->ComidaId)
												->first();
							if ($comida) {
								return $comida->ComidaNombre;
							}else{
								return '<p class="text-danger text-sm">No asignada</p>';
							}
						})
						->addColumn('ComidaPorTipoPacienteCostoTotal',function($comida){
								return "$".$comida->ComidaPorTipoPacienteCostoTotal;
							})
						->addColumn('btn','menues/actions/comidasActions')
	 					->rawColumns(['btn','ComidaId'])
	 					->toJson();
});
/* -----------------SALAS ---------------------- -*/
Route::get('salas',function(){

	$salas = DB::table('sala')->where('SalaEstado',1)->get();
	return DataTables::of($salas)
						->addColumn('SalaEstado',function($sala){
							if ($sala->SalaEstado == 1) {
								return '<td><p class="text-success">Activo</p></td>';
							}else{
								return '<td><p class="text-danger">Inactivo</p></td>';
							}
						})
					
						->addColumn('btn','salas/actions')
	 					->rawColumns(['SalaEstado','btn'])
	 					->toJson();
});
/* -----------------Piezas ---------------------- -*/

Route::get('piezas',function(Request $request){
	$id = $request['id'];
	$piezas = DB::table('pieza')->where('PiezaEstado',1)
								->where('SalaId',$id)
								->get();
	
	foreach ($piezas as $pieza) {
		$camas = DB::table('cama')->where('PiezaId', $pieza->PiezaId)
									->where('CamaEstado',1)
									->get();
		$pieza->Camas = count($camas);	
	}
	

	return DataTables::of($piezas)
						->addColumn('btn','salas/actionsPieza')
	 					->rawColumns(['btn'])
	 					->toJson();
});

/* -----------------Camas ---------------------- -*/
Route::get('camas',function(Request $request){
	$id = $request['id'];
	$camas = DB::table('cama')	->where('PiezaId',$id)
								->get();
	return DataTables::of($camas)
						->addColumn('CamaEstado',function($cama){
							if ($cama->CamaEstado == 1) {
								return '<td><p class="text-success">Activa</p></td>';
							}else{
								return '<td><p class="text-danger">Inactiva</p></td>';
							}
						})
						->addColumn('btn','salas/actionsCama')
	 					->rawColumns(['btn','CamaEstado'])
	 					->toJson();
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

/* -----------------ALIMENTOS ---------------------- -*/
Route::get('alimentos',function(){
	$alimentos = DB::table('alimento')->where('AlimentoEstado',1)->get();
	return DataTables::of($alimentos)
							->addColumn('AlimentoCantidadTotal',function($alimento){
								$unidadMedida = DB::table('unidadmedida')->where('UnidadMedidaId',$alimento->UnidadMedidaId)->first();
								return $alimento->AlimentoCantidadTotal.' '.$unidadMedida->UnidadMedidaNombre.'(s)';					
							})
						->addColumn('AlimentoCostoUnitario',function($alimento){
								if($alimento->AlimentoCantidadTotal != 0){
									return '$'.($alimento->AlimentoCostoTotal/$alimento->AlimentoCantidadTotal);
								}else{
									return '$0';
								}							
						})
						->addColumn('AlimentoCostoTotal',function($alimento){
							return '$'.$alimento->AlimentoCostoTotal;							
					})
						->addColumn('btn','alimentos/actions')
	 					->rawColumns(['btn'])
	 					->toJson();
});
/* -----------------ALIMENTOS POR PROVEEDOR---------------------- -*/
Route::get('alimentosporproveedor/{id}',function($id){

	$alimentosPorProveedor = DB::table('alimentoporproveedor as app')
								->join('alimento as a','a.AlimentoId','app.AlimentoId')
								->join('proveedor as p','p.ProveedorId','app.ProveedorId')
								->where('app.AlimentoId',$id)
								->get();
	foreach ($alimentosPorProveedor as $alimentoPorProveedor) {
		$alimentoPorProveedor->AlimentoPorProveedorCostoTotal = $alimentoPorProveedor->AlimentoPorProveedorCosto * $alimentoPorProveedor->AlimentoPorProveedorCantidad;
	}
	return DataTables::of($alimentosPorProveedor)
						->addColumn('btn','alimentos/actionsPorProveedor')
						->rawColumns(['AlimentoEstado','btn'])
	 					->toJson();
});
/* -----------------COMIDAS ---------------------- -*/
Route::get('comidas',function(){
	$comidas = DB::table('tipocomida as t')
            ->join('comida as c', 'c.TipoComidaId', '=', 't.TipoComidaId')
            ->where('c.ComidaEstado','=',1)
            ->get();
	return DataTables::of($comidas)
						->addColumn('btn','comidas/actions')
	 					->rawColumns(['ComidaEstado','btn'])
	 					->toJson();
});
/* -----------------ALIMENTOS POR COMIDA---------------------- -*/
Route::get('alimentosporcomida/{id}',function($id){

	$alimentosPorComida = DB::table('alimentoporcomida as apc')
								->join('alimento as a','a.AlimentoId','apc.AlimentoId')
								->join('unidadmedida as um','um.UnidadMedidaId','apc.UnidadMedidaId')
								->join('comida as c','c.ComidaId','apc.ComidaId')
								->where('apc.ComidaId',$id)
								->where('apc.AlimentoPorComidaEstado',1)
								->get();
	return DataTables::of($alimentosPorComida)
						->addColumn('btn','comidas/actionsAlimentoPorComida')
						->rawColumns(['AlimentoPorComidaEstado','btn'])
	 					->toJson();
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
/* -----------------cargar: NUTRIENTES DE ALIMENTOS ---------------------- -*/
Route::get('nutrientesporalimento/{id}',function($id){
	$nutrientes = DB::table('nutriente')->get();
	$nutrientesPorAlimentos = DB::table('nutrienteporalimento as npa')
								->join('nutriente as n','n.NutrienteId','npa.NutrienteId')
								->join('alimento as a','a.AlimentoId','npa.AlimentoId')
								->where('npa.AlimentoId',$id)
								->get();
	
	
	return DataTables::of($nutrientesPorAlimentos)
						->rawColumns(['NutrientePorAlimentoEstado'])
	 					->toJson();
});
/* -----------------RELEVAMIENTOS ---------------------- -*/
Route::get('relevamientos',function(){
	$relevamientos = DB::table('relevamiento')->where('RelevamientoEstado',1)->get();
	
	return DataTables::of($relevamientos)
						->addColumn('btn','relevamientos/actions')
						->rawColumns(['RelevamientoEstado','btn'])
	 					->toJson();
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

/* -----------------Usuarios---------------------- -*/
Route::get('usuarios',function(){
	$users = DB::table('users')->get();
	return DataTables::of($users)
						->addColumn('btn','usuarios/actions')
						->rawColumns(['btn'])
	 					->toJson();
});
