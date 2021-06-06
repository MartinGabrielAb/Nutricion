<?php

namespace App\Http\Controllers;

use App\Menu;
use Exception;
use App\Paciente;
use App\Relevamiento;
use App\TipoPaciente;
use App\DetalleRelevamiento;
use Illuminate\Http\Request;
use App\DetRelevamientoPorComida;
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
                                    ->join('sala as s','s.SalaId','r.SalaId')
                                    ->where('r.RelevamientoEstado',1)
                                    ->select('r.RelevamientoId',DB::raw('DATE_FORMAT(r.RelevamientoFecha, "%d/%m/%Y") as RelevamientoFecha'),'s.SalaId','s.SalaNombre','r.RelevamientoTurno','r.RelevamientoEstado');
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
        $salas = DB::table('sala')->where('SalaEstado','!=',-1)->get();
        return view('relevamientos.principal',compact('salas'));
    }

    public function create()
    { }

    public function store(RelevamientoRequest $request)
    {
        $sala = DB::table('sala')->where('SalaId')->where('SalaEstado','!=',-1)->get();
        $resultado = false;
        if($sala){
            $relevamiento = new Relevamiento;
            $relevamiento->RelevamientoEstado = 1;
            $relevamiento->SalaId = $request->get('salaId');
            $relevamiento->RelevamientoFecha = $request->get('fecha');
            $relevamiento->RelevamientoTurno = $request->get('turno');
            $resultado = $relevamiento->save();
        }
        if ($resultado) {
            return response()->json(['success'=> $relevamiento]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function show($id)
    {
        $relevamiento = DB::table('relevamiento as r')        
                        ->join('sala as s','s.SalaId','r.SalaId')
                        ->where('r.RelevamientoId',$id)
                        ->select('r.RelevamientoId',DB::raw('DATE_FORMAT(r.RelevamientoFecha, "%d/%m/%Y") as RelevamientoFecha'),'s.SalaPseudonimo','r.RelevamientoTurno','s.SalaId')
                        ->first();
        //datos necesarios para agregar y editar un detalle de relevamiento
        $pacientes = Paciente::where('PacienteEstado','!=',-1)
                            ->select('PacienteId','PacienteApellido','PacienteNombre','PacienteCuil')
                            ->get();
        $piezas = DB::table('sala as s')
                                ->join('pieza as p','p.SalaId','s.SalaId')
                                ->where('s.SalaId',$relevamiento->SalaId)
                                ->where('s.SalaEstado','1')
                                ->where('p.PiezaEstado','1')
                                ->orderby('s.SalaNombre','desc')
                                ->orderby('p.PiezaNombre','asc')
                                ->get();
        $tiposPaciente = TipoPaciente::all();
        $menus = Menu::where('MenuEstado',1)->get();
        $tiposcomida = DB::table('tipocomida')->where('TipoComidaEstado',1)->get();
        
        foreach ($tiposcomida as $index => $tipocomida) {
            $comidas = DB::table('comida')->where('TipoComidaId',$tipocomida->TipoComidaId)->where('ComidaEstado',1)->get();
            $tiposcomida[$index]->comidas = $comidas;
        }

        $colaciones = DB::table('comida as c')
                        ->join('tipocomida as tc','tc.TipoComidaId','c.TipoComidaId')
                        ->where('tc.TipoComidaNombre','Colación')
                        ->get();

        return view('relevamientos.show',compact('relevamiento','pacientes','piezas','tiposPaciente','menus','tiposcomida','colaciones'));
    }

    public function edit($id)
    { }

    public function update(RelevamientoRequest $request, $id)
    { 
        $sala = DB::table('sala')->where('SalaId')->where('SalaEstado','!=',-1)->get();
        $resultado = false;
        if($sala){
            $relevamiento = Relevamiento::findOrFail($id);
            $relevamiento->RelevamientoEstado = 1;
            $relevamiento->SalaId = $request->get('salaId');
            $relevamiento->RelevamientoFecha = $request->get('fecha');
            $relevamiento->RelevamientoTurno = $request->get('turno');
            $resultado = $relevamiento->update();
        }
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
                $detalleRelevamiento->DetalleRelevamientoEstado = -1;
                $detalleRelevamiento->update();
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