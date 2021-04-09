<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AlimentoPorComida;
use App\Comida;
use App\UnidadMedida;
use App\Alimento;
use App\ComidaPorTipoPaciente;
use App\DetalleMenuTipoPaciente;
use App\Menu;

class AlimentoPorComidaController extends Controller
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
        $datos = $request->all();
        $comida = Comida::FindOrFail($datos['comidaId']);
        $detalle = new AlimentoPorComida();
        $detalle->ComidaId = $datos['comidaId'];
        $detalle->AlimentoId = $datos['alimentoId'];
        $detalle->AlimentoPorComidaCantidadNeto = $datos['cantidadNeto'];
        $nombreUnidad = $datos['unidadMedida'];
        $unidadMedida = UnidadMedida::where('UnidadMedidaNombre','=',$nombreUnidad)->first(); 
        $detalle->UnidadMedidaId = $unidadMedida->UnidadMedidaId;
        $detalle->AlimentoPorComidaEstado = 1;
        $alimento = Alimento::FindOrFail($detalle->AlimentoId);
        $unidadMedidaAlimento = UnidadMedida::FindOrFail($alimento->UnidadMedidaId);
        $cantidadNeto = $detalle->AlimentoPorComidaCantidadNeto;
        $cantidadTotal = $alimento->AlimentoCantidadTotal;
        $costoTotal = $alimento->AlimentoCostoTotal;
        if($cantidadTotal != 0){
            if($unidadMedida->UnidadMedidaId == $unidadMedidaAlimento->UnidadMedidaId){
                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);

            }else{ 
                switch($unidadMedida->UnidadMedidaNombre){
                    case "Mililitro":
                        switch($unidadMedidaAlimento->UnidadMedidaNombre){
                            case 'Litro':
                                $cantidadNeto = $cantidadNeto/1000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                            break;
                            case 'Kilolitro':
                                $cantidadNeto = $cantidadNeto/1000000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                            break;
                        }
                    break;
                    case "Litro":
                        switch($unidadMedidaAlimento->UnidadMedidaNombre){
                            case 'Mililitro':
                                $cantidadNeto = $cantidadNeto*1000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                              
                            break;
                            case 'Kilolitro':
                                $cantidadNeto = $cantidadNeto/1000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                             
                            break;
                        }
                    break;
                    case "Kilolitro":
                        switch($unidadMedidaAlimento->UnidadMedidaNombre){
                            case 'Mililitro':
                                $cantidadNeto = $cantidadNeto*1000000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                                
                            break;
                            case 'Litro':
                                $cantidadNeto = $cantidadNeto*1000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                            break;
                        }
                    break;
                    case "Miligramo":
                        switch($unidadMedidaAlimento->UnidadMedidaNombre){
                            case 'Gramo':
                                $cantidadNeto = $cantidadNeto/1000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
    
                            break;
                            case 'Kilogramo':
                                $cantidadNeto = $cantidadNeto/1000000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                            break;
                        }
                    break;
                    case "Gramo":

                        switch($unidadMedidaAlimento->UnidadMedidaNombre){
                            case 'Gramo':
                                $cantidadNeto = $cantidadNeto;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                            break;
                            case 'Kilogramo':
                                $cantidadNeto = $cantidadNeto/1000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                            break;
                            case 'Litro':
                                $cantidadNeto = $cantidadNeto;  
                                $cantidadNeto = $cantidadNeto/$alimento->AlimentoEquivalenteGramos;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                            break;
                            case 'Unidad':  
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                                $detalle->UnidadMedidaId = $unidadMedidaAlimento->UnidadMedidaId;
                            break;
 
                        }
                    break;
                    case "Kilogramo":
                        switch($unidadMedidaAlimento->UnidadMedidaNombre){
                            case 'Miligramo':
                                $cantidadNeto = $cantidadNeto*1000000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                            break;
                            case 'Gramo':
                                $cantidadNeto = $cantidadNeto*1000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                            break;
                        }
                    break;     
                }
            }
        }
        else{
            $detalle->AlimentoPorComidaCostoTotal = 0;
        }
        $comidasPorTipoPaciente = ComidaPorTipoPaciente::where('ComidaId',$comida->ComidaId)->get();
        foreach($comidasPorTipoPaciente as $comidaPorTipoPaciente){
            $detallesMenuTipoPaciente = DetalleMenuTipoPaciente::where('DetalleMenuTipoPacienteId',$comidaPorTipoPaciente->DetalleMenuTipoPacienteId)->get();
            foreach($detallesMenuTipoPaciente as $detalleMenuTipoPaciente){
                $detalleMenuTipoPaciente->DetalleMenuTipoPacienteCostoTotal += $detalle->AlimentoPorComidaCostoTotal;
                $menu = Menu::FindOrFail($detalleMenuTipoPaciente->MenuId);
                $menu->MenuCostoTotal += $detalle->AlimentoPorComidaCostoTotal;
                $detalleMenuTipoPaciente->update();
                $menu->update();
            }

        }
        $comida->ComidaCostoTotal += $detalle->AlimentoPorComidaCostoTotal;
        $comida->Update();
        $resultado = $detalle->save();
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
        //
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
        $detalle = AlimentoPorComida::FindOrFail($id);
        $comida = Comida::FindOrFail($detalle->ComidaId);
        $comida->ComidaCostoTotal -= $detalle->AlimentoPorComidaCostoTotal;
        $costoViejo = $detalle->AlimentoPorComidaCostoTotal;
       
        $datos = $request->all();
        $detalle->AlimentoId = $datos['alimentoId'];
        $detalle->AlimentoPorComidaCantidadNeto = $datos['cantidadNeto'];
        $nombreUnidad = $datos['selectUnidadMedida'];
        $unidadMedida = UnidadMedida::where('UnidadMedidaNombre','=',$nombreUnidad)->first(); 
        $detalle->UnidadMedidaId = $unidadMedida->UnidadMedidaId;
        $alimento = Alimento::FindOrFail($detalle->AlimentoId);
        $unidadMedidaAlimento = UnidadMedida::FindOrFail($alimento->UnidadMedidaId);
        $cantidadNeto = $detalle->AlimentoPorComidaCantidadNeto;
        $cantidadTotal = $alimento->AlimentoCantidadTotal;
        $costoTotal = $alimento->AlimentoCostoTotal;
        
        if($cantidadTotal != 0){
            if($unidadMedida->UnidadMedidaId == $unidadMedidaAlimento->UnidadMedidaId){
                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
    
            }else{
                switch($unidadMedida->UnidadMedidaNombre){
                    case "Mililitro":
                        switch($unidadMedidaAlimento->UnidadMedidaNombre){
                            case 'Litro':
                                $cantidadNeto = $cantidadNeto/1000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                            break;
                            case 'Kilolitro':
                                $cantidadNeto = $cantidadNeto/1000000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                            break;
                        }
                    break;
                    case "Litro":
                        switch($unidadMedidaAlimento->UnidadMedidaNombre){
                            case 'Mililitro':
                                $cantidadNeto = $cantidadNeto*1000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                              
                            break;
                            case 'Kilolitro':
                                $cantidadNeto = $cantidadNeto/1000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                             
                            break;
                        }
                    break;
                    case "Kilolitro":
                        switch($unidadMedidaAlimento->UnidadMedidaNombre){
                            case 'Mililitro':
                                $cantidadNeto = $cantidadNeto*1000000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                                
                            break;
                            case 'Litro':
                                $cantidadNeto = $cantidadNeto*1000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                            break;
                        }
                    break;
                    case "Miligramo":
                        switch($unidadMedidaAlimento->UnidadMedidaNombre){
                            case 'Gramo':
                                $cantidadNeto = $cantidadNeto/1000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
    
                            break;
                            case 'Kilogramo':
                                $cantidadNeto = $cantidadNeto/1000000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                            break;
                        }
                    break;
                    case "Gramo":
                        switch($unidadMedidaAlimento->UnidadMedidaNombre){
                            case 'Miligramo':
                                $cantidadNeto = $cantidadNeto*1000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                            break;
                            case 'Kilogramo':
                                $cantidadNeto = $cantidadNeto/1000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                            break;
                        }
                    break;
                    case "Kilogramo":
                        switch($unidadMedidaAlimento->UnidadMedidaNombre){
                            case 'Miligramo':
                                $cantidadNeto = $cantidadNeto*1000000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                            break;
                            case 'Gramo':
                                $cantidadNeto = $cantidadNeto*1000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                            break;
                        }
                    break;    
                }
            }
        }
        else{
            $detalle->AlimentoPorComidaCostoTotal = 0;
        }
        $comidasPorTipoPaciente = ComidaPorTipoPaciente::where('ComidaId',$comida->ComidaId)->get();
        foreach($comidasPorTipoPaciente as $comidaPorTipoPaciente){
            $detallesMenuTipoPaciente = DetalleMenuTipoPaciente::where('DetalleMenuTipoPacienteId',$comidaPorTipoPaciente->DetalleMenuTipoPacienteId)->get();
            foreach($detallesMenuTipoPaciente as $detalleMenuTipoPaciente){
                $detalleMenuTipoPaciente->DetalleMenuTipoPacienteCostoTotal -= $costoViejo;
                $menu = Menu::FindOrFail($detalleMenuTipoPaciente->MenuId);
                $menu->MenuCostoTotal -= $costoViejo;
                $detalleMenuTipoPaciente->DetalleMenuTipoPacienteCostoTotal += $detalle->AlimentoPorComidaCostoTotal;
                $menu->MenuCostoTotal += $detalle->AlimentoPorComidaCostoTotal;
                $detalleMenuTipoPaciente->update();
                $menu->update();
            }

        }
        $comida->ComidaCostoTotal += $detalle->AlimentoPorComidaCostoTotal;
        $comida->Update();
        $resultado = $detalle->update();
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
        $detalle = AlimentoPorComida::FindOrFail($id);
        $comida = Comida::FindOrFail($detalle->ComidaId);
        $comida->ComidaCostoTotal -= $detalle->AlimentoPorComidaCostoTotal;
        $comidasPorTipoPaciente = ComidaPorTipoPaciente::where('ComidaId',$comida->ComidaId)->get();


        $costoViejo = $detalle->AlimentoPorComidaCostoTotal;
        foreach($comidasPorTipoPaciente as $comidaPorTipoPaciente){
            $detallesMenuTipoPaciente = DetalleMenuTipoPaciente::where('DetalleMenuTipoPacienteId',$comidaPorTipoPaciente->DetalleMenuTipoPacienteId)->get();
            foreach($detallesMenuTipoPaciente as $detalleMenuTipoPaciente){
                $detalleMenuTipoPaciente->DetalleMenuTipoPacienteCostoTotal -= $costoViejo;
                $menu = Menu::FindOrFail($detalleMenuTipoPaciente->MenuId);
                $menu->MenuCostoTotal -= $costoViejo;
                $detalleMenuTipoPaciente->update();
                $menu->update();
            }

        }
        $comida->Update();
        $resultado = $detalle->delete();
        if ($resultado) {
            return response()->json(['success' => 'true']);
        }else{
            return response()->json(['success'=>'false']);
        }

    }
}