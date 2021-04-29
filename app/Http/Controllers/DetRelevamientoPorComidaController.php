<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DetRelevamientoPorComidaController extends Controller
{
    public function show($id)
    {
        $comidasDelRelevamiento = 
            DB::table('detrelevamientoporcomida as drpc')
                ->join('comida as c','c.ComidaId','drpc.ComidaId')
                ->where('drpc.DetalleRelevamientoId',$id)
                ->get();
        if ($comidasDelRelevamiento) {
            return response()->json(['success' => $comidasDelRelevamiento]);
        }else{
            return response()->json(['success'=>'false']);
        }  
    }
}
