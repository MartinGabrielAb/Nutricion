<?php

namespace App\Http\Controllers;

use Exception;
use App\Paciente;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\PacienteRequest;
use DB ;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        /*---Pregunto si es una peticion ajax----*/
        if($request->ajax()){
            try{
                $pacientes = DB::table('paciente')
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
        $datos = $request->all();
        $paciente->PacienteNombre = $datos['nombre'];
        $paciente->PacienteApellido = $datos['apellido'];
        $paciente->PacienteDireccion = $datos['direccion'];
        $paciente->PacienteCuil = $datos['cuil'];
        $paciente->PacienteTelefono = $datos['telefono'];
        $paciente->PacienteEmail = $datos['email'];
        $paciente->PacienteEstado = $datos['estado'];;
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
                    'error' => $ex->getMessage()
                ], 500);
            }
        }
        $paciente = DB::table('paciente as pa')
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
        $paciente->PacienteNombre = $datos['nombre'];
        $paciente->PacienteApellido = $datos['apellido'];
        $paciente->PacienteDireccion = $datos['direccion'];
        $paciente->PacienteCuil = $datos['cuil'];
        $paciente->PacienteTelefono = $datos['telefono'];
        $paciente->PacienteEmail = $datos['email'];
        $paciente->PacienteEstado = $datos['estado'];;
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
            return response()->json(['success' => 'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}
