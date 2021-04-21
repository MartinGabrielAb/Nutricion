<?php

namespace App\Http\Controllers;

use Artisan;
use Exception;
use App\Persona;
use App\Paciente;
use App\DetalleRelevamiento;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CrearPersonaRequest;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        /*---Pregunto si es una peticion ajax----*/
        if($request->ajax()){
            try{
                $pacientes = DB::table('paciente as pac')
                    ->join('persona as per','per.PersonaId','=','pac.PersonaId')
                    ->where('PacienteEstado',1)
                    ->get();
                return DataTables::of($pacientes)
                                ->toJson();
            }catch(Exception $ex){
                return response()->json([
                    'error' => 'Internal server error.'
                ], 500);
            }
        }
        return view('pacientes.principal');
        
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
    public function show(Request $request,$id)
    {
         /*---Pregunto si es una peticion ajax----*/
        if($request->ajax()){
            try{
                $detallesrelevamiento = DB::table('detallerelevamiento as dr')
                                ->join('relevamiento as r','r.RelevamientoId','=','dr.RelevamientoId')
                                ->join('tipopaciente as tp','tp.TipoPacienteId','=','dr.TipoPacienteId')
                                ->join('cama as c','c.CamaId','=','dr.CamaId')
                                ->join('pieza as p','p.PiezaId','=','c.PiezaId')
                                ->join('sala as s','s.SalaId','=','p.SalaId')
                                ->join('users as u','u.id','=','dr.UserId')
                                ->where('dr.PacienteId',$id)
                                ->select('r.RelevamientoId',DB::raw('DATE_FORMAT(r.RelevamientoFecha, "%d/%m/%Y") as RelevamientoFecha'),'r.RelevamientoTurno','tp.TipoPacienteNombre','c.CamaNumero','p.PiezaNombre','s.SalaNombre','u.name','dr.DetalleRelevamientoId','dr.DetalleRelevamientoFechora','dr.DetalleRelevamientoEstado','dr.DetalleRelevamientoAcompaniante','dr.DetalleRelevamientoObservaciones','dr.DetalleRelevamientoDiagnostico')
                                ->orderBy('dr.created_at')
                                ->get();
                return DataTables::of($detallesrelevamiento)
                                ->toJson();
            }catch(Exception $ex){
                return response()->json([
                    'error' => 'Internal server error.'
                ], 500);
            }
        }
        $paciente = DB::table('paciente as pa')
                    ->join('persona as pe','pe.PersonaId','pa.PersonaId')
                    ->where('pa.PacienteId',$id)
                    ->first();
        return view('pacientes.show',compact('paciente'));
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
