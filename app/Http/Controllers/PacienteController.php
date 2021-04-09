<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paciente;
use App\Persona;
use DB;
use Artisan;
use App\Http\Requests\CrearPersonaRequest;
class PacienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $pacientes = DB::table('paciente as pac')
                    ->join('persona as per','per.PersonaId','=','pac.PersonaId')
                    ->where('PacienteEstado',1)
                    ->get();
        return view('pacientes.principal',compact('pacientes'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pacientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datos = $request->All();
        $persona = new Persona();
        $paciente = new Paciente();
        $persona->PersonaNombre = $datos['nombre'];
        $persona->PersonaApellido = $datos['apellido'];
        $persona->PersonaDireccion = $datos['direccion'];
        $persona->PersonaCuil = $datos['cuil'];
        $persona->PersonaTelefono = $datos['telefono'];
        $persona->PersonaSexo = $datos['sexo'];
        $persona->PersonaEmail = $datos['email'];
        $persona->PersonaEstado = 1;
        $persona->save();
        $paciente->PersonaId = $persona->PersonaId;
        $paciente->PacienteEstado = 1;
        $paciente->save();
        return redirect()->action('PacienteController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {  
        
        $paciente = DB::table('paciente as pac')
                    ->join('persona as per','per.PersonaId','=','pac.PersonaId')
                    ->where('PacienteId',$id)
                    ->first();
        return view('pacientes.edit',compact('paciente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $paciente = Paciente::FindOrFail($id);
        $datos = $request->all();
        $persona = Persona :: FindOrFail($paciente->PersonaId);
        $persona->PersonaNombre = $datos ['nombre'];
        $persona->PersonaApellido = $datos ['apellido'];
        $persona->PersonaCuil = $datos ['cuil'];
        $persona->PersonaDireccion = $datos ['direccion'];
        $persona->PersonaEmail = $datos['email'];
        $persona->PersonaTelefono = $datos ['telefono'];
        $persona->PersonaSexo = $datos ['sexo'];
        $persona->Update();
        return redirect()->action('PacienteController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paciente = Paciente::FindOrFail($id);
        $paciente->PacienteEstado = 0;
        $paciente->update();
        return redirect()->action('PacienteController@index');
    }
}
