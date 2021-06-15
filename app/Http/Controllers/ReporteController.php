<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\RelevamientosExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProduccionRacionesExport;

class ReporteController extends Controller
{
    public function exportRelevamientosExcel(Request $request){
        /*---Pregunto si es una peticion ajax----*/
        if($request->ajax()){//PacienteCuil, RelevamientoFechaIni, RelevamientoFechaFin, SalaId
            try{
                $pacienteCuil = $request->get('PacienteCuil');
                $relevamientoFechaIni = $request->get('RelevamientoFechaIni');
                $relevamientoFechaFin = $request->get('RelevamientoFechaFin');
                $salaId = $request->get('SalaId');
                return Excel::download(new RelevamientosExport($pacienteCuil,$relevamientoFechaIni,$relevamientoFechaFin,$salaId), 'relevamientos-list.xlsx');
            }catch(Exception $ex){
                return response()->json([
                    'error' => $ex->getMessage()
                ], 500);
            }
        }
        $salas = DB::table('sala')->where('SalaEstado',1)->get();
        return view('reportes.relevamientos',compact('salas'));
    }

    public function exportProduccionRacionesExcel(Request $request){
        /*---Pregunto si es una peticion ajax----*/
        if($request->ajax()){//RelevamientoFechaIni, RelevamientoFechaFin
            try{
                $relevamientoFechaIni = $request->get('RelevamientoFechaIni');
                $relevamientoFechaFin = $request->get('RelevamientoFechaFin');
                return Excel::download(new ProduccionRacionesExport($relevamientoFechaIni,$relevamientoFechaFin),'produccionraciones.xlsx');
            }catch(Exception $ex){
                return response()->json([
                    'error' => $ex->getMessage()
                ], 500);
            }
        }
        return view('reportes.produccionraciones');
    }

}
