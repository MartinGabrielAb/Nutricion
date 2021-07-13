<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Comida;
use App\Alimento;
use App\Nutriente;
use App\TipoComida;
use App\TipoPaciente;
use Illuminate\Http\Request;
use App\ComidaPorTipoPaciente;
use App\DetalleMenuTipoPaciente;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ComidaPorTipoPacienteRequest;

class ComidaPorTipoPacienteController extends Controller
{
    public function index()
    { }

    public function create()
    { }

    public function store(ComidaPorTipoPacienteRequest $request)
    {
        $nuevo =new ComidaPorTipoPaciente();
        $nuevo->DetalleMenuTipoPacienteId = $request['detalleMenuTipoPacienteId'];
        $nuevo->ComidaId = $request['comida'];
        $nuevo->ComidaPorTipoPacientePrincipal = $request['principal'];
        $resultado = $nuevo->save();
        if ($resultado) {
            return response()->json(['success' => $nuevo]);
        }else{
            return response()->json(['success'=>'false']);
        }  
    }

    // La utilizo para sacar las comidas de ese detallemenutipopaciente: 
    // id : DetalleMenuTipoPacienteId
    public function show($id)
    {
        $comidas = DB::table('comidaportipopaciente as cp')
        ->where('DetalleMenuTipoPacienteId',$id)
        ->join('comida as c','c.ComidaId','cp.ComidaId')                                
        ->join('tipocomida as tc','c.TipoComidaId','tc.TipoComidaId')
        ->orderBy('tc.TipoComidaId','asc')
        ->get();
        return response($comidas);

        // $detalles = ComidaPorTipoPaciente::where('DetalleMenuTipoPacienteId',$id)->get();
        // //Para armar la tabla de nutrientes obtengo las comidas indexadas
        //     $nombresNutriente = Nutriente::All();
        //     $comidas = array();
        //     foreach ($detalles as $detalle) {
        //         if($detalle->ComidaId !=NULL){
        //             array_push($comidas, Comida::FindOrFail($detalle->ComidaId));
        //         }
        //     }
        //     $valoresTotales=array();
          
        //     foreach ($comidas as $comida) {
        //         $alimentosPorComida = DB::table('alimentoporcomida')->where('ComidaId','=',$comida->ComidaId)->get();
        //         foreach ($alimentosPorComida as $alimentoPorComida) {
        //             $cantidad = $alimentoPorComida->AlimentoPorComidaCantidadNeto;
        //             $alimento = Alimento::FindOrFail($alimentoPorComida->AlimentoId);
        //             $nutrientes = DB::table('nutrienteporalimento')->where('AlimentoId','=',$alimento->AlimentoId)->get();
        //             $cont = 0;
        //             foreach ($nutrientes as $nutriente) {
        //                 if(!empty($valoresTotales[$cont])){
        //                     $valoresTotales[$cont] = $valoresTotales[$cont] + ($cantidad * $nutriente->NutrientePorAlimentoValor);
        //                 }else{
        //                     $valoresTotales[$cont] =$cantidad * $nutriente->NutrientePorAlimentoValor;
        
        //                 }
        //                 $cont = $cont +1 ; 
        //             }
        //         }
        //     }


        //     return view('menues.comidasporpaciente', compact('detalles','nombresNutriente','valoresTotales'));
    }

    //Lo utilizo para traer los nutrientes de 
    // un array de comidas desde comidaportipopaciente/nutrientes.js
    public function edit(Request $request,$id)
    {   
        
        $listaComidas = $request['comidas'];
        $respuesta = array();
        $valoresTotales=array();
        $comidasArray = array();
        foreach ($listaComidas as $comidaId) {
            $comida = DB::table('comida as c')->where('ComidaId',$comidaId)
                                ->join('tipoComida as tc','tc.TipoComidaId','c.TipoComidaId')
                                ->first();
            $comidaArray = array();
            $alimentosPorComida = DB::table('alimentoporcomida as apc')
                                    ->join('alimento as a','a.AlimentoId','apc.AlimentoId')
                                    ->join('unidadmedida as u','u.UnidadMedidaId','apc.UnidadMedidaId')
                                    ->where('ComidaId','=',$comida->ComidaId)
                                    ->get();
            $alimentosArray = array();
            foreach ($alimentosPorComida as $alimentoPorComida) {
                $cantidad = $alimentoPorComida->AlimentoPorComidaCantidadNeto;
                $alimentoArray = array();
                $nutrientes = DB::table('nutrienteporalimento')
                                ->where('AlimentoId','=',$alimentoPorComida->AlimentoId)
                                ->get();
                $cont = 0;
                $nutrientesArray = array();
                if($alimentoPorComida->UnidadMedidaNombre == 'Unidad' ) {
                    foreach ($nutrientes as $nutriente) {
                        array_push($nutrientesArray,round($cantidad * $nutriente->NutrientePorAlimentoValor,2));
                        if(!empty($valoresTotales[$cont])){
                            $valoresTotales[$cont] = $valoresTotales[$cont] + ($cantidad * $nutriente->NutrientePorAlimentoValor);
                        }else{
                            $valoresTotales[$cont] =$cantidad * $nutriente->NutrientePorAlimentoValor;
    
                        }
                        $cont = $cont +1 ; 
                    }
                }else{
                    foreach ($nutrientes as $nutriente) {
                        array_push($nutrientesArray, round($nutriente->NutrientePorAlimentoValor/100 * $cantidad,2));
                        if(!empty($valoresTotales[$cont])){
                            $valoresTotales[$cont] = $valoresTotales[$cont] + ($cantidad * $nutriente->NutrientePorAlimentoValor/100);
                        }else{
                            $valoresTotales[$cont] =$cantidad * $nutriente->NutrientePorAlimentoValor/100;
    
                        }
                        $cont = $cont +1 ; 
                    }
                }
                $alimentoArray =[
                    "alimento" => $alimentoPorComida->AlimentoNombre,
                    "alimentoId" => $alimentoPorComida->AlimentoId,
                    "cantidad" => $cantidad,
                    "nutrientes" => $nutrientesArray,
                ];
                array_push($alimentosArray,$alimentoArray);
            }
            $comidaArray = [
                "tipoComida" => $comida->TipoComidaNombre,
                "comida" => $comida->ComidaNombre,
                "comidaId" =>$comida->ComidaId,
                "alimentos" => $alimentosArray,
            ];
            array_push($comidasArray,$comidaArray);
        }
        $respuesta = [
            "comidas" => $comidasArray,
            "totales" => $valoresTotales,
        ];
        return response($respuesta);
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
