<?php

namespace App\Http\Controllers;

use Exception;
use App\Empleado;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EmpleadoRequest;

class EmpleadoController extends Controller
{
    public function index(Request $request)
    {
        /*---Pregunto si es una peticion ajax----*/
        if($request->ajax()){
            try{
                $empleados = DB::table('empleado as e')
                    ->where('EmpleadoEstado',1)
                    ->orwhere('EmpleadoEstado',0)
                    ->get();

                return DataTables::of($empleados)
                                ->addColumn('btn','empleados/actions')
                                ->rawColumns(['btn'])
                                ->toJson();
            }catch(Exception $ex){
                return response()->json([
                    'error' => $ex->getMessage()
                ], 500);
            }
        }
        return view('empleados.principal');
        
    }

    public function create()
    { }

    public function store(EmpleadoRequest $request)
    {
        $empleado = new Empleado();
        $datos = $request->all();
        $empleado->EmpleadoNombre = $datos['nombre'];
        $empleado->EmpleadoApellido = $datos['apellido'];
        $empleado->EmpleadoDireccion = $datos['direccion'];
        $empleado->EmpleadoCuil = $datos['cuil'];
        $empleado->EmpleadoTelefono = $datos['telefono'];
        $empleado->EmpleadoEmail = $datos['email'];
        $empleado->EmpleadoEstado = $datos['estado'];;
        $resultado = $empleado->save();
        if ($resultado) {
            return response()->json(['success' => $empleado]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function show(Request $request,$id)
    { }


    public function edit($id)
    { }

    public function update(EmpleadoRequest $request, $id)
    {
        $datos = $request->all();
        $empleado = Empleado::FindOrFail($id);
        $empleado->EmpleadoNombre = $datos['nombre'];
        $empleado->EmpleadoApellido = $datos['apellido'];
        $empleado->EmpleadoDireccion = $datos['direccion'];
        $empleado->EmpleadoCuil = $datos['cuil'];
        $empleado->EmpleadoTelefono = $datos['telefono'];
        $empleado->EmpleadoEmail = $datos['email'];
        $empleado->EmpleadoEstado = $datos['estado'];;
        $resultado = $empleado->Update();
        if ($resultado) {
            return response()->json(['success' => [$empleado]]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function destroy($id)
    {
        $empleado = Empleado::FindOrFail($id);
        $empleado->EmpleadoEstado = -1;
        $resultado = $empleado->update();
        if ($resultado) {
            return response()->json(['success' => 'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}
