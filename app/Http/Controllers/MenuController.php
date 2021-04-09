<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use App\Comida;
use App\TipoComida;
use App\Nutriente;
use App\TipoPaciente;
use App\DetalleMenuTipoPaciente;
use App\ComidaPorTipoPaciente;
use Illuminate\Support\Facades\Auth;

use DB;

class MenuController extends Controller
{
    
     public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {

        return view('menues.principal');
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
        
        $particular = $request['menuParticular'];
        $menu = new Menu();
        $menu->MenuNombre= $request['menuNombre'];
        $menu->MenuEstado = 1;
        $menu->MenuCostoTotal = 0;
        if ($particular == 0) {
            $menu->MenuParticular = 0;       
            $resultado= $menu ->save();
        }else{
            /*Creo un particular que tenga un solo detalle*/
            $menu->MenuParticular = 1;
            $menu->save();
            $detalleMenuTipoPaciente =new DetalleMenuTipoPaciente();
            $detalleMenuTipoPaciente->MenuId = $menu->MenuId;
            $tipoPaciente = TipoPaciente::where('TipoPacienteNombre','Particular')->first();
            $detalleMenuTipoPaciente->TipoPacienteId = $tipoPaciente->TipoPacienteId;
            $detalleMenuTipoPaciente->DetalleMenuTipoPacienteCostoTotal = 0;
            $resultado = $detalleMenuTipoPaciente->save();
        }
        if ($resultado) {
            return response()->json(['success' => $menu]);
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
        $menu = Menu::FindOrFail($id);
        $tipospaciente = TipoPaciente::where('TipoPacienteNombre','!=','Particular')->get();
        return view('menues.show',compact('menu','tipospaciente'));
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
        $menu = Menu::FindOrFail($id);
        $menu->MenuNombre = $request['menuNombre'];
        $resultado = $menu->update();
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
        $menu = Menu::findOrFail($id);
        $detallesMenuTipoPaciente = DetalleMenuTipoPaciente::where('MenuId', '=', $menu->MenuId)->get();
        foreach ($detallesMenuTipoPaciente as $detalleMenuTipoPaciente){
            $comidasPorTipoPaciente = ComidaPorTipoPaciente::where('DetalleMenuTipoPacienteId','=',$detalleMenuTipoPaciente->DetalleMenuTipoPacienteId)->get();
            foreach ($comidasPorTipoPaciente as $comidaPorTipoPaciente){
                $comidaPorTipoPaciente->delete();
            }
            $detalleMenuTipoPaciente->delete();
        }
        $resultado = $menu->delete();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}
