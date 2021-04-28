<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Sala;
use Exception;
use App\Paciente;
use App\Relevamiento;
use App\TipoPaciente;
use App\DetalleRelevamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\RelevamientoRequest;

class RelevamientoController extends Controller
{
    public function index(Request $request)
    {
        /*---Pregunto si es una peticion ajax----*/
        if($request->ajax()){
            try{
                $relevamientos = DB::table('relevamiento as r')
                                            ->where('r.RelevamientoEstado',1)
                                            ->select('r.RelevamientoId',DB::raw('DATE_FORMAT(r.RelevamientoFecha, "%d/%m/%Y") as RelevamientoFecha','r.RelevamientoEstado'))
                                            ->get();
                return DataTables::of($relevamientos)
                            ->addColumn('btn','relevamientos/actions')
                             ->rawColumns(['btn'])
                             ->toJson();
            }catch(Exception $ex){
                return response()->json([
                    'error' => $ex->getMessage()
                ], 500);
            }
        }
        return view('relevamientos.principal');
    }

    public function create()
    { }

    public function store(RelevamientoRequest $request)
    {
        $relevamiento = new Relevamiento;
        $relevamiento->RelevamientoEstado = 1;
        $relevamiento->RelevamientoFecha = $request->get('fecha');
        $resultado = $relevamiento->save();
        if ($resultado) {
            return response()->json(['success'=> $relevamiento]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function show($id)
    {
        $relevamiento = Relevamiento::findOrFail($id);
        //datos necesarios para agregar y editar un detalle de relevamiento
        $pacientes = Paciente::select('paciente.PersonaId','paciente.PacienteId','persona.PersonaApellido','persona.PersonaNombre','persona.PersonaCuil')
                ->join('persona', 'persona.PersonaId', '=', 'paciente.PersonaId')
                ->get();
        $salasPiezasCamas = Sala::join('pieza','pieza.SalaId','sala.SalaId')
                                    ->join('cama','cama.PiezaId','pieza.PiezaId')
                                    ->orderby('SalaNombre','desc')
                                    ->orderby('pieza.PiezaNombre','asc')
                                    ->orderby('cama.CamaNumero','asc')
                                    ->get();
        $tiposPaciente = TipoPaciente::all();
        $menus = Menu::where('MenuEstado',1)->get();
        return view('relevamientos.show',compact('relevamiento','pacientes','salasPiezasCamas','tiposPaciente','menus'));
    }

    public function edit($id)
    { }

    public function update(RelevamientoRequest $request, $id)
    { 
        $relevamiento = Relevamiento::findOrFail($id);
        $relevamiento->RelevamientoEstado = 1;
        $relevamiento->RelevamientoFecha = $request->get('fecha');
        $resultado = $relevamiento->update();
        if ($resultado) {
            return response()->json(['success'=> $relevamiento]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function destroy($id)
    {
        $relevamiento = Relevamiento::findOrFail($id);
        $detallesRelevamiento = DetalleRelevamiento::where("RelevamientoId",$relevamiento->RelevamientoId)->get();
        if($detallesRelevamiento){
            foreach ($detallesRelevamiento as $detalleRelevamiento) {
                $detalleRelevamiento->DetalleRelevamientoEstado = 0;
            }
        }
        $relevamiento->RelevamientoEstado = 0;
        $resultado = $relevamiento->update();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}