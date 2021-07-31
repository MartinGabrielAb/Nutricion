<?php

namespace App\Http\Controllers;

use Exception;
use App\Paciente;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\PacienteRequest;
use Illuminate\Support\Facades\DB;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        /*---Pregunto si es una peticion ajax----*/
        if($request->ajax()){
            try{
                $pacientes = DB::table('paciente')->where('PacienteEstado','!=',-1);
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
                $detallesRelevamiento = 
                    DB::table('detallerelevamiento as dr')
                    ->join('relevamientoporsala as rps','rps.RelevamientoPorSalaId','dr.RelevamientoPorSalaId')
                    ->join('relevamiento as re','re.RelevamientoId','rps.RelevamientoId')
                    ->join('paciente as pa','pa.PacienteId','dr.PacienteId')
                    ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                    ->join('cama as c','c.CamaId','dr.CamaId')
                    ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                    ->join('sala as s','s.SalaId','pi.SalaId')
                    ->join('users as u','u.id','dr.UserId')
                    ->join('menu as m','m.MenuId','dr.MenuId')
                    ->where('dr.PacienteId',$id)
                    ->select(DB::raw('DATE_FORMAT(re.RelevamientoFecha, "%d/%m/%Y") as RelevamientoFecha'),'re.RelevamientoId',
                            'dr.DetalleRelevamientoId',
                            DB::raw('DATE_FORMAT(dr.updated_at, "%H:%i:%s") as DetalleRelevamientoHora'),
                            'dr.DetalleRelevamientoDiagnostico',
                            'dr.DetalleRelevamientoAcompaniante',
                            'dr.DetalleRelevamientoVajillaDescartable',
                            'dr.DetalleRelevamientoEstado','dr.DetalleRelevamientoObservaciones',
                            'm.MenuNombre',
                            'pa.PacienteId','pa.PacienteNombre','pa.PacienteApellido','pa.PacienteCuil',
                            'tp.TipoPacienteNombre',
                            'c.CamaNumero','pi.PiezaPseudonimo','s.SalaPseudonimo',
                            'u.name as Relevador')
                    ->orderby('dr.DetalleRelevamientoId','desc')
                    ->get();
                return DataTables::of($detallesRelevamiento)
                                ->addColumn('btn','pacientes/actionsShow')
                                ->rawColumns(['btn'])
                                ->toJson();
            }catch(Exception $ex){
                return response()->json([
                    'error' => $ex->getMessage()
                ], 500);
            }
        }
        $paciente = DB::table('paciente as pa')->where('pa.PacienteId',$id)->first();
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
