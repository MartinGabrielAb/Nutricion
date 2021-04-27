<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ComidaPorTipoPaciente;
use App\TipoComida;
use App\Comida;
use App\Alimento;
use App\DetalleMenuTipoPaciente;
use App\TipoPaciente;
use App\Menu;
use DB;
use App\Nutriente;
use App\Http\Requests\ComidaPorTipoPacienteRequest;

class ComidaPorTipoPacienteController extends Controller
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

    public function create()
    {
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ComidaPorTipoPacienteRequest $request)
    {
        $nuevo =new ComidaPorTipoPaciente();
        $nuevo->DetalleMenuTipoPacienteId = $request['detalleMenuTipoPacienteId'];
        $nuevo->ComidaId = $request['comida'];
        $resultado = $nuevo->save();
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
        $detalles = ComidaPorTipoPaciente::where('DetalleMenuTipoPacienteId',$id)->get();
        //Para armar la tabla de nutrientes obtengo las comidas indexadas
            $nombresNutriente = Nutriente::All();
            $comidas = array();
            foreach ($detalles as $detalle) {
                if($detalle->ComidaId !=NULL){
                    array_push($comidas, Comida::FindOrFail($detalle->ComidaId));
                }
            }
            $valoresTotales=array();
          
            foreach ($comidas as $comida) {
                $alimentosPorComida = DB::table('alimentoporcomida')->where('ComidaId','=',$comida->ComidaId)->get();
                foreach ($alimentosPorComida as $alimentoPorComida) {
                    $cantidad = $alimentoPorComida->AlimentoPorComidaCantidadNeto;
                    $alimento = Alimento::FindOrFail($alimentoPorComida->AlimentoId);
                    $nutrientes = DB::table('nutrienteporalimento')->where('AlimentoId','=',$alimento->AlimentoId)->get();
                    $cont = 0;
                    foreach ($nutrientes as $nutriente) {
                        if(!empty($valoresTotales[$cont])){
                            $valoresTotales[$cont] = $valoresTotales[$cont] + ($cantidad * $nutriente->NutrientePorAlimentoValor);
                        }else{
                            $valoresTotales[$cont] =$cantidad * $nutriente->NutrientePorAlimentoValor;
        
                        }
                        $cont = $cont +1 ; 
                    }
                }
            }


            return view('menues.comidasporpaciente', compact('detalles','nombresNutriente','valoresTotales'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        
        $menuTipoPaciente = DetalleMenuTipoPaciente::FindOrFail($id);
        $tipoPaciente = TipoPaciente::FindOrFail($menuTipoPaciente->TipoPacienteId);
        $tiposComida = TipoComida::OrderBy('TipoComidaNombre','asc')->get();
        $detalles = ComidaPorTipoPaciente::where('DetalleMenuTipoPacienteId',$id)
                                            ->get();

            //Para armar la tabla de nutrientes obtengo las comidas indexadas
            $nombresNutriente = Nutriente::All();
            $comidas = array();
            foreach ($detalles as $detalle) {
                if($detalle->ComidaId !=NULL){
                    array_push($comidas, Comida::FindOrFail($detalle->ComidaId));
                }
            }
            $valoresTotales=array();
          
            foreach ($comidas as $comida) {
                $alimentosPorComida = DB::table('alimentoporcomida')->where('ComidaId','=',$comida->ComidaId)->get();
                foreach ($alimentosPorComida as $alimentoPorComida) {
                    $cantidad = $alimentoPorComida->AlimentoPorComidaCantidadNeto;
                    $alimento = Alimento::FindOrFail($alimentoPorComida->AlimentoId);
                    $nutrientes = DB::table('nutrienteporalimento')->where('AlimentoId','=',$alimento->AlimentoId)->get();
                    $cont = 0;
                    foreach ($nutrientes as $nutriente) {
                        if(!empty($valoresTotales[$cont])){
                            $valoresTotales[$cont] = $valoresTotales[$cont] + ($cantidad * $nutriente->NutrientePorAlimentoValor);
                        }else{
                            $valoresTotales[$cont] =$cantidad * $nutriente->NutrientePorAlimentoValor;
        
                        }
                        $cont = $cont +1 ; 
                    }
                }
            }
            return view('menues.asignarcomidaporpaciente', compact('id','tiposComida','detalles','nombresNutriente','valoresTotales','tipoPaciente'));
        }

    public function update(Request $request, $id)
    {
        $comidaPorTipoPaciente = ComidaPorTipoPaciente::FindOrFail($request['id']);
        $detalleMenuTipoPaciente = DetalleMenuTipoPaciente::FindOrFail($comidaPorTipoPaciente->DetalleMenuTipoPacienteId);
        $menu = Menu::FindOrFail($detalleMenuTipoPaciente->MenuId);
        $comidaVieja = Comida::where('ComidaId',$comidaPorTipoPaciente->ComidaId)->first();
                /* ---------Actualizo los costos-------------*/
        if ($comidaVieja != NULL) {
            $comidaPorTipoPaciente->ComidaPorTipoPacienteCostoTotal -= $comidaVieja->ComidaCostoTotal;
            $detalleMenuTipoPaciente->DetalleMenuTipoPacienteCostoTotal -= $comidaVieja->ComidaCostoTotal;
            $menu->MenuCostoTotal -= $comidaVieja->ComidaCostoTotal;
        }
        $comidaNueva = Comida::FindOrFail($request['comidaId']); 
        $comidaPorTipoPaciente->ComidaPorTipoPacienteCostoTotal += $comidaNueva->ComidaCostoTotal;
        $comidaPorTipoPaciente->ComidaId = $comidaNueva->ComidaId;
        $comidaPorTipoPaciente->update();
        $detalleMenuTipoPaciente->DetalleMenuTipoPacienteCostoTotal += $comidaNueva->ComidaCostoTotal;
        $detalleMenuTipoPaciente->update();
        $menu->MenuCostoTotal += $comidaNueva->ComidaCostoTotal;
        $resultado = $menu->update();
        if ($resultado) {
            return response()->json(['success' => 'true']);
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

        $comidaPorTipoPaciente = ComidaPorTipoPaciente::FindOrFail($id);
        // $detalleMenuTipoPaciente = DetalleMenuTipoPaciente::FindOrFail($comidaPorTipoPaciente->DetalleMenuTipoPacienteId);
        // $menu = Menu::FindOrFail($detalleMenuTipoPaciente->MenuId);

        // $comida = Comida::where('ComidaId','=',$comidaPorTipoPaciente->ComidaId)->first();
        // if($comida != NULL){
        //     $comidaPorTipoPaciente->ComidaPorTipoPacienteCostoTotal -= $comida->ComidaCostoTotal;
        //     $comidaPorTipoPaciente->update();
        //     $detalleMenuTipoPaciente->DetalleMenuTipoPacienteCostoTotal -= $comida->ComidaCostoTotal;
        //     $detalleMenuTipoPaciente->update();
        //     $menu->MenuCostoTotal -= $comida->ComidaCostoTotal;
        //     $menu->update();
        // }
        $resultado = $comidaPorTipoPaciente->delete();
        if ($resultado) {
            return response()->json(['success' => 'true']);
        }else{
            return response()->json(['success'=>'false']);
        }

    }


}
