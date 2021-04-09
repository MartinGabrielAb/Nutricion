<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetalleMenuTipoPaciente;
use App\ComidaPorTipoPaciente;
use App\Menu;
use DB;

class MenuPorTipoPacienteController extends Controller
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
        $detalleMenu = new DetalleMenuTipoPaciente();
        $detalleMenu->MenuId = $request['menuId'];
        $detalleMenu->TipoPacienteId = $request['tipoPaciente'];
        $detalleMenu->DetalleMenuTipoPacienteCostoTotal = 0;  
        $resultado = $detalleMenu->save();
        if ($resultado) {
            return response()->json(['success' => 'true']);
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
        $menu = DetalleMenuTipoPaciente::FindOrFail($id);
        $tiposcomida = DB::table('tipocomida')
                        ->where('TipoComidaEstado',1)
                        ->get();
        return view('menues.comidas',compact('menu','tiposcomida'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detalleMenuTipoPaciente = DetalleMenuTipoPaciente::FindOrFail($id);
        $comidasPorTipoPaciente = ComidaPorTipoPaciente::where('DetalleMenuTipoPacienteId','=',$id)->get();
        foreach($comidasPorTipoPaciente as $detalle){
            $detalle->delete();
        }
        $menu = Menu::FindOrFail($detalleMenuTipoPaciente->MenuId);
        $menu->MenuCostoTotal -= $detalleMenuTipoPaciente->DetalleMenuTipoPacienteCostoTotal;
        $menu->update();
        $resultado = $detalleMenuTipoPaciente->delete();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}
