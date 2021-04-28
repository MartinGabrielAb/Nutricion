<?php

namespace App\Http\Controllers;

use Exception;
use App\Paciente;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\PacienteRequest;
use Illuminate\Support\Facades\DB as FacadesDB;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        /*---Pregunto si es una peticion ajax----*/
        if($request->ajax()){
            try{
                $pacientes = FacadesDB::table('paciente as pac')
                    ->join('persona as per','per.PersonaId','=','pac.PersonaId')
                    ->where('PacienteEstado',1)
                    ->orwhere('PacienteEstado',0)
                    ->get();

                return DataTables::of($pacientes)
                                ->addColumn('btn','pacientes/actions')
                                ->rawColumns(['btn'])
                                ->toJson();
            }catch(Exception $ex){
                return response()->json([
                    'error' => $ex->getMessage()
                ], 500);
            }
        }
        return view('pacientes.principal');
        
    }

    public function create()
    { }

    public function store(PacienteRequest $request)
    {
        $paciente = new Paciente();
        $paciente->PersonaId = $request->personaId;
        $paciente->PacienteEstado = (int)$request->estado;
        $resultado = $paciente->save();
        if ($resultado) {
            return response()->json(['success' => $paciente]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function show(Request $request,$id)
    {
         /*---Pregunto si es una peticion ajax----*/
        if($request->ajax()){
            try{
                $detallesrelevamiento = FacadesDB::table('detallerelevamiento as dr')
                                ->join('relevamiento as r','r.RelevamientoId','=','dr.RelevamientoId')
                                ->join('tipopaciente as tp','tp.TipoPacienteId','=','dr.TipoPacienteId')
                                ->join('cama as c','c.CamaId','=','dr.CamaId')
                                ->join('pieza as p','p.PiezaId','=','c.PiezaId')
                                ->join('sala as s','s.SalaId','=','p.SalaId')
                                ->join('users as u','u.id','=','dr.UserId')
                                ->where('dr.PacienteId',$id)
                                ->select('r.RelevamientoId',FacadesDB::raw('DATE_FORMAT(r.RelevamientoFecha, "%d/%m/%Y") as RelevamientoFecha'),'r.RelevamientoTurno','tp.TipoPacienteNombre','c.CamaNumero','p.PiezaNombre','s.SalaNombre','u.name','dr.DetalleRelevamientoId','dr.DetalleRelevamientoFechora','dr.DetalleRelevamientoEstado','dr.DetalleRelevamientoAcompaniante','dr.DetalleRelevamientoObservaciones','dr.DetalleRelevamientoDiagnostico')
                                ->orderBy('dr.created_at')
                                ->get();
                return DataTables::of($detallesrelevamiento)
                                ->toJson();
            }catch(Exception $ex){
                return response()->json([
                    'error' => $ex->getMessage()
                ], 500);
            }
        }
        $paciente = FacadesDB::table('paciente as pa')
                    ->join('persona as pe','pe.PersonaId','pa.PersonaId')
                    ->where('pa.PacienteId',$id)
                    ->first();
        return view('pacientes.show',compact('paciente'));
    }


    public function edit($id)
    { }

    public function update(PacienteRequest $request, $id)
    {
        $datos = $request->all();
        $paciente = Paciente::FindOrFail($id);
        $paciente->PacienteEstado = $datos['estado'];
        $resultado = $paciente->Update();
        if ($resultado) {
            return response()->json(['success' => [$paciente]]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function destroy($id)
    {
        $paciente = Paciente::FindOrFail($id);
        $paciente->PacienteEstado = -1;
        $resultado = $paciente->update();
        if ($resultado) {
            return response()->json(['success' => ['true']]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}
