<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoComida;
use App\Comida;
use App\ComidaPorTipoPaciente;
use App\AlimentoPorComida;
use App\DetalleMenuTipoPaciente;
use App\Menu;


use DB;

class ComidaController extends Controller
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
        return view('comidas.principal');
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
        $datos = $request->all();
        $nombreComida = $datos['nombreComida'];
        $tipoComida = $datos['tipoComida'];
        $comida = new Comida();
        $comida->ComidaNombre = $nombreComida;
        $comida->TipoComidaId = $tipoComida;
        $comida->ComidaCostoTotal = 0;
        $comida->ComidaEstado = 1;
        $resultado = $comida->save();
        if ($resultado) {
            return response()->json(['success'=>'true']);
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
        $comida = Comida::findOrFail($id);
        return view('comidas.show',compact('comida'));
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
        $comida = Comida::FindOrFail($id);
        $datos = $request->all();
        $comida->ComidaNombre = $datos['nombreComida'];
        $comida->TipoComidaId = $datos['tipoComida'];
        $comidasPorTipoPaciente = ComidaPorTipoPaciente::where('ComidaId', $comida->ComidaId)->get();
        foreach($comidasPorTipoPaciente as $comidaPorTipoPaciente){
            $comidaPorTipoPaciente->TipoComidaId = $comida->TipoComidaId;
            $comidaPorTipoPaciente->update();
        }
        $resultado = $comida->update();
        if ($resultado) {
            return response()->json(['success'=>'true']);
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
        $comida = Comida::FindOrFail($id);
        /*Elimino los alimentos que tiene dentro*/
        $alimentosPorComida = AlimentoPorComida::where('ComidaId','=',$comida->ComidaId)->get();
        foreach ($alimentosPorComida as $alimentoPorComida) {
             $alimentoPorComida->delete();
         } 
        $comidasPorTipoPaciente = ComidaPorTipoPaciente::where('ComidaId','=',$comida->ComidaId)->get();
        foreach($comidasPorTipoPaciente as $comidaPorTipoPaciente){
            $comidaPorTipoPaciente->ComidaId = NULL;
            $comidaPorTipoPaciente->comidaPorTipoPacienteCostoTotal -= $comida->ComidaCostoTotal;
            $detallesMenuTipoPaciente= DetalleMenuTipoPaciente::where('DetalleMenuTipoPacienteId','=',$comidaPorTipoPaciente->DetalleMenuTipoPacienteId)->get();
            foreach($detallesMenuTipoPaciente as $detalleMenuTipoPaciente){
                $detalleMenuTipoPaciente->DetalleMenuTipoPacienteCostoTotal -= $comida->ComidaCostoTotal;
                
                $menu = Menu::findOrFail($detalleMenuTipoPaciente->MenuId);
                $menu->MenuCostoTotal -= $comida->ComidaCostoTotal; 
                 
                $detalleMenuTipoPaciente->update();
                $menu->update();
            }
            $comidaPorTipoPaciente->update();
        }
        $resultado = $comida->delete();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}