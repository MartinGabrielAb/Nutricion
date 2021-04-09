<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NutrientePorAlimento;
use App\Alimento;
use DB;
class NutrientePorAlimentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $alimentoId = $request['alimentoId'];
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $alimento = Alimento::findOrFail($id);
        $nutrientes = DB::TABLE('nutriente as n')
                        ->join('unidadmedida as u','u.UnidadMedidaId','=','n.UnidadMedidaId')
                        ->orderBy('n.NutrienteId','asc')
                        ->get();
        return view('nutrientesporalimento.show',compact('alimento','nutrientes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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