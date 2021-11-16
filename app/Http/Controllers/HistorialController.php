<?php

namespace App\Http\Controllers;
use Response;
use App\Menu;
use App\Comida;
use App\Alimento;
use App\Historial;
use App\TipoComida;
use App\Relevamiento;
use App\TipoPaciente;
use App\UnidadMedida;
use App\AlimentoPorComida;
use App\DetalleRelevamiento;
use Illuminate\Http\Request;
use App\ComidaPorTipoPaciente;
use App\HistorialTipoPaciente;
use App\DetalleMenuTipoPaciente;
use Illuminate\Support\Facades\DB;
use App\HistorialAlimentoPorComida;
use App\HistorialComidaPorTipoPaciente;
class HistorialController extends Controller
{

    public function index(Request $request)
    {
        if($request->ajax()){
            # Ejecuta si la petición es a través de AJAX.
            $historial = DB::table('historial as h')
                                    ->where('HistorialEstado',1)
                                    ->join('relevamiento as r','r.RelevamientoId','h.RelevamientoId')
                                    ->join('menu as m','m.MenuId','r.RelevamientoMenu')
                                    ->get();
            if($historial){
                return datatables()->of($historial)
                                    ->addColumn('btn','historial/actions')
                                    ->rawColumns(['btn'])
                                    ->toJson();
            }
        }
        # Ejecuta si la petición NO es a través de AJAX.
        return view('historial.principal');
    }

    public function create($id)
    {

    }

    public function store(Request $request)
    {}
    public function show($id, Request $request)
    {   
        if($request->ajax()){
            $historial = DB::table('historial as h')
                                    ->where('HistorialId',$id)
                                    ->join('relevamiento as r','r.RelevamientoId','h.RelevamientoId')
                                    ->join('menu as m','m.MenuId','r.RelevamientoMenu')
                                    ->first();
            $detallesComidas = DB::table('historialdetallecomida')
                                ->where('HistorialId',$historial->HistorialId)
                                ->where('ParaPersonal',0)
                                ->get();
                               

            $detallesComidasEmpleados = DB::table('historialdetallecomida')
                                ->where('HistorialId',$historial->HistorialId)
                                ->where('ParaPersonal',1)
                                ->get();
            $comidas = Array();
            $comidasEmpleados = Array();
            foreach($detallesComidas as $detalleComida){
                $alimentos = DB::table('historialdetallealimento')
                                ->where('HistorialDetalleComidaId',$detalleComida->HistorialDetalleComidaId)
                                ->get();
                $detalle = Array(
                    'id' => $detalleComida->HistorialDetalleComidaId,
                    'comida' => $detalleComida->ComidaNombre,
                    'porciones'=> $detalleComida->Porciones,
                    'alimentos' => $alimentos
                );
                array_push($comidas,$detalle);
            }
            foreach($detallesComidasEmpleados as $detalleComida){
                $alimentos = DB::table('historialdetallealimento')
                                ->where('HistorialDetalleComidaId',$detalleComida->HistorialDetalleComidaId)
                                ->get();
                $detalle = Array(
                    'id' => $detalleComida->HistorialDetalleComidaId,
                    'comida' => $detalleComida->ComidaNombre,
                    'porciones'=> $detalleComida->Porciones,
                    'alimentos' => $alimentos
                );
                array_push($comidasEmpleados,$detalle);
            }                   
            $data = Array(
                'historial'=> $historial,
                'detalles'=> $comidas,
                'detallesEmpleados' =>$comidasEmpleados
            );      
            return response()->json($data);

        }
        return view('historial.show',compact('id'));

    }

    public function edit($id) 
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {}

}
