<?php

namespace App\Http\Controllers;

use Exception;
use App\Proveedor;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProveedorRequest;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {

       /*---Pregunto si es una peticion ajax----*/
        if($request->ajax()){
            try{
                $proveedores = DB::table('proveedor as p')
                    ->where('ProveedorEstado',1)
                    ->orwhere('ProveedorEstado',0)
                    ->get();
                return DataTables::of($proveedores)
                                ->addColumn('btn','proveedores/actions')
                                ->rawColumns(['btn'])
                                ->toJson();
            }catch(Exception $ex){
                return response()->json([
                    'error' => $ex->getMessage()
                ], 500);}
        }
        return view('proveedores.principal');
    }

    public function create()
    {
      
    }

    public function store(ProveedorRequest $request)
    {
        $proveedor = new Proveedor();
        $datos = $request->all();
        $proveedor->ProveedorNombre = $datos['nombre'];
        $proveedor->ProveedorDireccion = $datos['direccion'];
        $proveedor->ProveedorCuit = $datos['cuit'];
        $proveedor->ProveedorTelefono = $datos['telefono'];
        $proveedor->ProveedorEmail = $datos['email'];
        $proveedor->ProveedorEstado = $datos['estado'];;
        $resultado = $proveedor->save();
        if ($resultado) {
            return response()->json(['success' => $proveedor]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }


    public function edit($id)
    {    
    }

    public function update(ProveedorRequest $request, $id = null)
    {
    
        $datos = $request->all();
        $proveedor = Proveedor::FindOrFail($id);
        $proveedor->ProveedorNombre = $datos['nombre'];
        $proveedor->ProveedorDireccion = $datos['direccion'];
        $proveedor->ProveedorCuit = $datos['cuit'];
        $proveedor->ProveedorTelefono = $datos['telefono'];
        $proveedor->ProveedorEmail = $datos['email'];
        $proveedor->ProveedorEstado = $datos['estado'];;
        $resultado = $proveedor->Update();
        if ($resultado) {
            return response()->json(['success' => [$proveedor]]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::FindOrFail($id);
        $proveedor->ProveedorEstado = -1;
        $resultado = $proveedor->update();
        if ($resultado) {
            return response()->json(['success' => 'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

}
