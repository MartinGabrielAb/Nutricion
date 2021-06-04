<?php

namespace App\Http\Controllers;

use App\Alimento;
use Illuminate\Http\Request;
use App\NutrientePorAlimento;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class NutrientePorAlimentoController extends Controller
{

    public function index()
    {   }

    public function create()
    {    }


    public function store(Request $request)
    {
        $alimentoId = $request['alimentoId'];
        $nutrientesViejos = DB::table('nutrienteporalimento')
                            ->where('AlimentoId',$alimentoId)
                            ->get();
        if(count($nutrientesViejos) != 0){
            foreach($nutrientesViejos as $nutriente){
                DB::table('nutrienteporalimento')
                ->where('NutrientePorAlimentoId', $nutriente->NutrientePorAlimentoId)
                ->delete();
            }
        }
        $nutrientes = $request['nutrientes'];
        foreach ($nutrientes as $nutriente) {
            $nutrientePorAlimento = new NutrientePorAlimento;
            $nutrientePorAlimento->AlimentoId = $alimentoId;
            $nutrientePorAlimento->NutrientePorAlimentoValor = $nutriente['valor'];
            $nutrientePorAlimento->NutrienteId = $nutriente['nutrienteId'];
            $resultado = $nutrientePorAlimento->save();
        }
        if ($resultado) {
            return response()->json(['success' =>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function show(Request $request,$id)
    {
        $nutrientesPorAlimento = DB::table('nutrienteporalimento as npa')
                                    ->join('nutriente as n','n.NutrienteId','npa.NutrienteId')
                                    ->join('alimento as a','a.AlimentoId','npa.AlimentoId')
                                    ->join('unidadmedida as u','u.UnidadMedidaId','n.UnidadMedidaId')
                                    ->orderBy('n.NutrienteId','asc')
                                    ->where('npa.AlimentoId',$id)
                                    ->get();
        if($request->ajax()){
             return DataTables::of($nutrientesPorAlimento)
                                ->toJson();
        }
        $nutrientes = DB::table('nutriente as n')
                        ->join('unidadmedida as u','u.UnidadMedidaId','n.UnidadMedidaId')
                        ->orderBy('n.NutrienteId','asc')
                         ->get();
        $alimento = DB::table('alimento as a')
                        ->join('unidadmedida as u','u.UnidadMedidaId','a.UnidadMedidaId')
                        ->where('AlimentoId',$id)
                        ->first();
        return view('nutrientesporalimento.principal',compact('alimento','nutrientesPorAlimento','nutrientes'));
    }

    public function edit($id)
    { }

    public function update(Request $request, $id)
    {
        $nutrientePorAlimento = NutrientePorAlimento::findOrFail($id);
        $nutrientePorAlimento->AlimentoId = $request->get('alimentoId');
        $nutrientePorAlimento->NutrienteId = $request->get('nutrienteId');
        $nutrientePorAlimento->NutrientePorAlimentoValor = $request->get('valor');
        $resultado = $nutrientePorAlimento->update();
        if ($resultado) {
            return response()->json(['success' =>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function destroy($id)
    {
        $nutrientePorAlimento = NutrientePorAlimento::findOrFail($id);
        $resultado = $nutrientePorAlimento->delete();
        if ($resultado) {
            return response()->json(['success' =>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}