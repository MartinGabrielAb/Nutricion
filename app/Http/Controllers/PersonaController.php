<?php

namespace App\Http\Controllers;

use App\Persona;
use App\Paciente;
use Illuminate\Http\Request;
use App\Http\Requests\PersonaRequest;

class PersonaController extends Controller
{
    public function index()
    { 
         /*---Pregunto si es una peticion ajax----*/
         if($request->ajax()){
            try{
                $personas = FacadesDB::table('sala')->where('SalaEstado',1)->get();
                return DataTables::of($salas)
                            ->addColumn('btn','salas/actions')
                            ->rawColumns(['btn'])
                            ->toJson();
            }catch(Exception $ex){
                return response()->json([
                    'error' => $ex->getMessage()
                ], 500);
            }
        }
        return view('salas.principal');
    }

    public function create()
    { }

    public function store(PersonaRequest $request)
    {
        $datos = $request->All();
        $persona = Persona::where('PersonaCuil',$datos['dni'])->where('PersonaEstado',1)->first();
        if($persona){
            $persona->PersonaNombre = $datos['nombre'];
            $persona->PersonaApellido = $datos['apellido'];
            $persona->PersonaDireccion = $datos['direccion'];
            $persona->PersonaCuil = $datos['dni'];
            $persona->PersonaTelefono = $datos['telefono'];
            $persona->PersonaEmail = $datos['email'];
            $persona->PersonaEstado = 1;
            $resultado = $persona->update();
        }else{
            $persona = new Persona();
            $persona->PersonaNombre = $datos['nombre'];
            $persona->PersonaApellido = $datos['apellido'];
            $persona->PersonaDireccion = $datos['direccion'];
            $persona->PersonaCuil = $datos['dni'];
            $persona->PersonaTelefono = $datos['telefono'];
            $persona->PersonaEmail = $datos['email'];
            $persona->PersonaEstado = 1;
            $resultado = $persona->save();
        }
        if ($resultado) {
            return response()->json(['success' => [$persona]]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function show($id)
    { }

    public function edit($id)
    { }

    public function update(PersonaRequest $request, $id)
    { 
        $datos = $request->all();
        $persona = Persona::where('PersonaCuil',$datos['dni'])->where('PersonaEstado',1)->first();
        if($persona){
            $persona->PersonaNombre = $datos['nombre'];
            $persona->PersonaApellido = $datos['apellido'];
            $persona->PersonaDireccion = $datos['direccion'];
            $persona->PersonaCuil = $datos['dni'];
            $persona->PersonaTelefono = $datos['telefono'];
            $persona->PersonaEmail = $datos['email'];
            $persona->PersonaEstado = 1;
            $resultado = $persona->update();
        }else{
            $paciente = Paciente::FindOrFail($id);
            $persona = Persona :: FindOrFail($paciente->PersonaId);
            $persona->PersonaNombre = $datos['nombre'];
            $persona->PersonaApellido = $datos['apellido'];
            $persona->PersonaDireccion = $datos['direccion'];
            $persona->PersonaCuil = $datos['dni'];
            $persona->PersonaTelefono = $datos['telefono'];
            $persona->PersonaEmail = $datos['email'];
            $persona->PersonaEstado = 1;
            $resultado = $persona->Update();
        }
        if ($resultado) {
            return response()->json(['success' => $persona]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function destroy($id)
    { }
}
