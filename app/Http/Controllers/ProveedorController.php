<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;
use App\Http\Requests\RequestProveedor;

class ProveedorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            # Ejecuta si la petición es a través de AJAX.
            $proveedores = Proveedor::where('ProveedorEstado',1)->get();
            if ($proveedores) {
                return datatables()->of($proveedores)
                                    ->addColumn('btn','proveedores/actions')
                                    ->rawColumns(['btn'])
                                    ->toJson();
            }
            return $this->genericResponse(null,"No se encontraron proveedores",500);
        }
        # Ejecuta si la petición NO es a través de AJAX.
        return view('proveedores/principal');
    }

    public function create()
    {
      
    }

    public function store(RequestProveedor $request)
    {
        $datos = $request->all();
        $proveedor = new Proveedor();
        $proveedor->ProveedorNombre = $datos['nombre'];
        $proveedor->ProveedorCuit = $datos['cuit'];
        $proveedor->ProveedorDireccion = $datos['direccion'];
        $proveedor->ProveedorTelefono = $datos['telefono'];
        $proveedor->ProveedorEmail = $datos['email'];
        $proveedor->ProveedorEstado = 1;
        $proveedor->save();
        return $this->genericResponse($proveedor,null,200);
    }

    public function show($id)
    {
        if ($id == null) {
            
            $this->genericResponse(null,"ID no fue encontrado",500);
        }   
        $proveedor = Proveedor::findOrFail($id);              
        if (!$proveedor) {
            return $this->genericResponse(null,"Proveedor no encontrado",500);
        }
        return $this->genericResponse($proveedor,"",200);
    }

    public function edit($id)
    {    
    }

    public function update(RequestProveedor $request, $id = null)
    {
    
        $datos = $request->all();
        $proveedor = Proveedor::findOrFail($id);
        if (!$proveedor) {
                return $this->genericResponse(null,"El proveedor no existe",500); 
            }
        $proveedor->ProveedorNombre = $datos['nombre'];
        $proveedor->ProveedorCuit = $datos['cuit'];
        $proveedor->ProveedorDireccion = $datos['direccion'];
        $proveedor->ProveedorTelefono = $datos['telefono'];
        $proveedor->ProveedorEmail = $datos['email'];
        $proveedor->ProveedorEstado = 1;
        $respuesta = $proveedor->update();
        if ($respuesta) {
            return $this->genericResponse($proveedor,null,200);
        }
         return $this->genericResponse(null,"Error al actualizar el registro.",500);
    }

    public function destroy($id)
    {
        if ($id == null) {
            $this->genericResponse(null,"ID no fue encontrado",500);
        }   
        $proveedor = Proveedor::findOrFail($id);              
        if (!$proveedor) {
            return $this->genericResponse(null,"Proveedor no encontrado",500);
        }
        $proveedor->ProveedorEstado = 0;
        $respuesta = $proveedor->update();
        if ($respuesta) {
            return $this->genericResponse("Proveedor eliminado con exito.","",200);
            }
        return $this->genericResponse(null,"No se pudo eliminar el proveedor",500);
    }

    private function genericResponse($data, $msj, $code){
        if ($code == 200) {
            return response()
                ->json([
                    "data" => $data,
                    "code" => $code,
                    
                ]);
        }else{
            return response()->json([
                "msj" => $msj,
                "code" => $code,
            ]);
        }
    }
}
