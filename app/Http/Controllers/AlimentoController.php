<?php

namespace App\Http\Controllers;

use Exception;
use App\Alimento;
use App\Proveedor;
use App\UnidadMedida;
use Illuminate\Http\Request;
use App\AlimentoPorProveedor;
use App\NutrientePorAlimento;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AlimentoRequest;

class AlimentoController extends Controller
{

 
    public function index(Request $request)
    {   
        /*---Pregunto si es una peticion ajax----*/
        if($request->ajax()){
            try{
                $alimentos = DB::table('alimento')->where('AlimentoEstado',1);
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
            }catch(Exception $ex){
                return response()->json([
                    'error' => 'Internal server error.'
                ], 500);
            }
        }
        $unidadesMedida = UnidadMedida::all();
        return view('alimentos.principal',compact('unidadesMedida'));
    }


    public function create()
    {    }

    public function store(AlimentoRequest $request)
    {

        $datos = $request->all();
        $unidadMedida = UnidadMedida::findOrFail($datos['unidad']);
        $alimento =new Alimento();
        $alimento->AlimentoNombre = $datos['nombre'];
        $alimento->UnidadMedidaId = $unidadMedida->UnidadMedidaId;
        if($unidadMedida->UnidadMedidaNombre == 'Litro'){
            $alimento->AlimentoEquivalenteGramos = $datos['equivalente'];
        }
        if($unidadMedida->UnidadMedidaNombre == 'Kilogramo'){
            $alimento->AlimentoEquivalenteGramos = 1000;
        }
        if($unidadMedida->UnidadMedidaNombre == 'Gramo'){
            $alimento->AlimentoEquivalenteGramos = 1;
        }
        if($unidadMedida->UnidadMedidaNombre == 'Unidad'){
            $alimento->AlimentoEquivalenteGramos = NULL;
        }
        $alimento->AlimentoEstado = 1;
        $alimento->AlimentoCantidadTotal = 0;
        $alimento->AlimentoCostoTotal = 0;
        $resultado = $alimento->save();
        if ($resultado) {
            return response()->json(['success' => 'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    //El show lo utilizo para ver los alimenos por proveedor
    public function show(Request $request,$id)
    {
        if($request->ajax()){
            try{
                $alimentosPorProveedor = DB::table('alimentoporproveedor as app')
								->join('alimento as a','a.AlimentoId','app.AlimentoId')
								->join('proveedor as p','p.ProveedorId','app.ProveedorId')
								->where('app.AlimentoId',$id)
								->get();
                foreach ($alimentosPorProveedor as $alimentoPorProveedor) {
                    $alimentoPorProveedor->AlimentoPorProveedorCostoTotal = $alimentoPorProveedor->AlimentoPorProveedorCosto * $alimentoPorProveedor->AlimentoPorProveedorCantidad;
                }
                return DataTables::of($alimentosPorProveedor)
                                ->addColumn('btn','alimentosporproveedor/actions')
                                ->rawColumns(['AlimentoEstado','btn'])
                                ->toJson();
            }catch(Exception $ex){
                return response()->json([
                    'error' => 'Internal server error.'
                ], 500);
            }
        }
        $alimento = DB::table('alimento as a')
                                ->join('unidadmedida as u','u.UnidadMedidaId','a.UnidadMedidaId')
                                ->where('AlimentoId',$id)
                                ->first();
        $proveedores = Proveedor::all();
        return view('alimentosporproveedor.principal',compact('alimento','proveedores'));
    }

    public function edit($id)
    {    }
    public function update(Request $request, $id)
    {    }

    public function destroy($id)
    {
        $alimento = Alimento::FindOrFail($id);
        $alimentoPorProveedor = AlimentoPorProveedor::where('AlimentoId','=',$id)->get();
        foreach ($alimentoPorProveedor as $alimentoPorProveedor) {
            $alimentoPorProveedor->delete();
        }
        $nutrientesPorAlimento = NutrientePorAlimento::where('AlimentoId','=',$id)->get();
        foreach ($nutrientesPorAlimento as $nutrientePorAlimento) {
            $nutrientePorAlimento->delete();
        }
        $resultado = $alimento->delete();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}