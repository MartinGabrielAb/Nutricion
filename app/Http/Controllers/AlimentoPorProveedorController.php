<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AlimentoPorProveedor;
use App\Alimento;
use App\UnidadMedida;
use App\AlimentoPorComida;
use App\Comida;
use App\ComidaPorTipoPaciente;
use App\DetalleMenuTipoPaciente;
use App\Menu;
use App\Http\Requests\AlimentoPorProveedorRequest;

class AlimentoPorProveedorController extends Controller
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
    public function store(AlimentoPorProveedorRequest $request)
    {
        //Creo el nuevo detalle del alimento por proveedor 
        $datos = $request->all();
        $alimento = Alimento::FindOrFail($datos['alimentoId']);
        $alimentoPorProveedor =new AlimentoPorProveedor();
        $alimentoPorProveedor->ProveedorId = $datos['proveedor'];
        $alimentoPorProveedor->AlimentoId = $datos['alimentoId'];
        $alimentoPorProveedor->AlimentoPorProveedorVencimiento=$datos['vencimiento'];
        $alimentoPorProveedor->AlimentoPorProveedorCantidad = $datos['cantidad'];
        $alimentoPorProveedor->AlimentoPorProveedorCosto = $datos['costo'];
        $alimentoPorProveedor->AlimentoPorProveedorCostoTotal = 0;
        if($alimento->AlimentoEquivalenteGramos != NULL){
            $alimentoPorProveedor->AlimentoPorProveedorCantidadGramos = $alimentoPorProveedor->AlimentoPorProveedorCantidad * $alimento->AlimentoEquivalenteGramos;
        }else{
            $alimentoPorProveedor->AlimentoPorProveedorCantidadGramos = NULL;
        }
        $alimentoPorProveedor->AlimentoPorProveedorEstado = 1;
        $resultado = $alimentoPorProveedor->save();
        /*-------------------------Actualizar costos---------------------------------*/

        // Actualizar costo total de despensa
        
        $alimento->AlimentoCantidadTotal += $alimentoPorProveedor->AlimentoPorProveedorCantidad;
        $alimento->AlimentoCostoTotal += $alimentoPorProveedor->AlimentoPorProveedorCantidad * $alimentoPorProveedor->AlimentoPorProveedorCosto;
        $resultado = $alimento->update();
        
        /*--------------Actualizo costos de menu y comida--------------*/
        //OBTENGO EL COSTO NUEVO
        //Ejemplo:      cantidad= 2kg pollo -- costoTotal=  $400 -- costoPorKilo = $200 
        $cantidadTotal = $alimento->AlimentoCantidadTotal;
        $costoTotal = $alimento->AlimentoCostoTotal;
        if($cantidadTotal != 0){
            $costoPorUnidadMedida = $costoTotal / $cantidadTotal;
        
            //Obtengo el nombre de la unidad de medida en la que esta guardado el alimento en despensa
            $unidadMedidaAlimento = UnidadMedida::FindOrFail($alimento->UnidadMedidaId);
            $nombreUnidadMedidaAlimento = $unidadMedidaAlimento->UnidadMedidaNombre;

            //Busco todas las comidas donde aparezca ese alimento
            $alimentosPorComida = AlimentoPorComida::where('AlimentoId','=',$alimento->AlimentoId)->get();
            //Recorro los detalles para encontrar las comidas donde el alimento aparece
            if(!$alimentosPorComida->isEmpty()){
                foreach($alimentosPorComida as $alimentoPorComida){
                    //GUARDO EL COSTO VIEJO
                    $costoViejo = $alimentoPorComida->AlimentoPorComidaCostoTotal;

                    //Busco la unidad de medida en la que esta el alimento en cada detalle
                    $unidadMedidaDetalle = UnidadMedida::FindOrFail($alimentoPorComida->UnidadMedidaId);
                    $nombreUnidadMedidaDetalle = $unidadMedidaDetalle->UnidadMedidaNombre;

                    /*--------------OBTENGO EL COSTO DEL ALIMENTO EN CADA LINEA DE DETALLE NUEVO----------------*/
                    $alimentoPorComidaCantidadNeto = $alimentoPorComida->AlimentoPorComidaCantidadNeto;
                    if( $nombreUnidadMedidaDetalle == $nombreUnidadMedidaAlimento ){

                        $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * $costoPorUnidadMedida;
                
                    }else{
                        switch($nombreUnidadMedidaDetalle){
                            case "Gramo":
                                switch($nombreUnidadMedidaAlimento){
                                    case 'Unidad':
                                        $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida);
                                    break;
                                    case 'Gramo':
                                        $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida);
                                    break;
                                    case 'Litro':
                                        $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * $costoPorUnidadMedida / $alimento->AlimentoEquivalenteGramos;
                                    break;
                                    case 'Kilogramo':
                                        $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida/1000);
                                    break;
                                }
                            break;
                           
                        }

                    }
                    $alimentoPorComida->update();

                    //Busco la comida y actualizo los costos
                    $comida = Comida::FindOrFail($alimentoPorComida->ComidaId);
                    $comida->ComidaCostoTotal -= $costoViejo;
                    $comida->ComidaCostoTotal += $alimentoPorComida->AlimentoPorComidaCostoTotal;
                    $comida->Update();
                    //Busco los detalles donde fue asignada esa comida
                    $comidasPorTipoPaciente = ComidaPorTipoPaciente::where('ComidaId','=',$comida->ComidaId)->get();
                    foreach($comidasPorTipoPaciente as $comidaPorTipoPaciente){
                        //Actualizo el costo de los detalles donde estaba asignada esa comida
                        $comidaPorTipoPaciente->ComidaPorTipoPacienteCostoTotal -= $costoViejo;
                        $comidaPorTipoPaciente->ComidaPorTipoPacienteCostoTotal += $alimentoPorComida->AlimentoPorComidaCostoTotal;
                        $comidaPorTipoPaciente->Update();
                        //Busco el tipo de menu y actualizo el costo
                        $detalleMenuTipoPaciente = DetalleMenuTipoPaciente::FindOrFail($comidaPorTipoPaciente->DetalleMenuTipoPacienteId);
                        $detalleMenuTipoPaciente->DetalleMenuTipoPacienteCostoTotal -= $costoViejo;
                        $detalleMenuTipoPaciente->DetalleMenuTipoPacienteCostoTotal += $alimentoPorComida->AlimentoPorComidaCostoTotal;
                        $detalleMenuTipoPaciente->Update();
                        //Busco el Menu para actualizar el costo
                        $menu = Menu::FindOrFail($detalleMenuTipoPaciente->MenuId);
                        $menu->MenuCostoTotal -= $costoViejo;
                        $menu->MenuCostoTotal += $alimentoPorComida->AlimentoPorComidaCostoTotal;
                        $resultado = $menu->update();
                    }
                }
            }
        }
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
        // $datos = $request->all();
        
        // $alimentoPorProveedor = AlimentoPorProveedor::FindOrFail($id);
        // $alimento = Alimento::FindOrFail($alimentoPorProveedor->AlimentoId); 
        // $alimento->AlimentoCantidadTotal -= $alimentoPorProveedor->AlimentoPorProveedorCantidad;
        // $alimento->AlimentoCostoTotal -= $alimentoPorProveedor->AlimentoPorProveedorCantidad * $alimentoPorProveedor->AlimentoPorProveedorCosto;
        // $alimentoPorProveedor->ProveedorId = $datos['proveedor'];
        // $alimentoPorProveedor->AlimentoPorProveedorVencimiento=$datos['vencimiento'];
        // $alimentoPorProveedor->AlimentoPorProveedorCantidad = $datos['cantidad'];
        // $alimentoPorProveedor->AlimentoPorProveedorCosto = $datos['precio'];
        // $alimentoPorProveedor->AlimentoPorProveedorEstado = 1;
        // $resultado = $alimentoPorProveedor->update();
        // $alimento->AlimentoCantidadTotal += $alimentoPorProveedor->AlimentoPorProveedorCantidad;
        // $alimento->AlimentoCostoTotal += $alimentoPorProveedor->AlimentoPorProveedorCantidad * $alimentoPorProveedor->AlimentoPorProveedorCosto;
        // $resultado = $alimento->update();

        // /*--------------Actualizo costos de menu y comida--------------*/
        // //OBTENGO EL COSTO NUEVO
        // //Ejemplo:      cantidad= 2kg pollo -- costoTotal=  $400 -- costoPorKilo = $200 
        // $cantidadTotal = $alimento->AlimentoCantidadTotal;
        // $costoTotal = $alimento->AlimentoCostoTotal;
        // if($cantidadTotal != 0){
        //     $costoPorUnidadMedida = $costoTotal / $cantidadTotal;

        //     //Obtengo el nombre de la unidad de medida en la que esta guardado el alimento en despensa
        //     $unidadMedidaAlimento = UnidadMedida::FindOrFail($alimento->UnidadMedidaId);
        //     $nombreUnidadMedidaAlimento = $unidadMedidaAlimento->UnidadMedidaNombre;

        //     //Busco todas las comidas donde aparezca ese alimento
        //     $alimentosPorComida = AlimentoPorComida::where('AlimentoId','=',$alimento->AlimentoId)->get();
        //     //Recorro los detalles para encontrar las comidas donde el alimento aparece
        //     if(!$alimentosPorComida->isEmpty()){
        //         foreach($alimentosPorComida as $alimentoPorComida){
        //             //GUARDO EL COSTO VIEJO
        //             $costoViejo = $alimentoPorComida->AlimentoPorComidaCostoTotal;

        //             //Busco la unidad de medida en la que esta el alimento en cada detalle
        //             $unidadMedidaDetalle = UnidadMedida::FindOrFail($alimentoPorComida->UnidadMedidaId);
        //             $nombreUnidadMedidaDetalle = $unidadMedidaDetalle->UnidadMedidaNombre;

        //             /*--------------OBTENGO EL COSTO DEL ALIMENTO EN CADA LINEA DE DETALLE NUEVO----------------*/
        //             $alimentoPorComidaCantidadNeto = $alimentoPorComida->AlimentoPorComidaCantidadNeto;
        //             if( $nombreUnidadMedidaDetalle == $nombreUnidadMedidaAlimento ){

        //                 $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * $costoPorUnidadMedida;
                
        //             }else{

        //                 switch($nombreUnidadMedidaDetalle){
        //                     case "Mililitro":
        //                         switch($nombreUnidadMedidaAlimento){
        //                             case 'Litro':
        //                                 $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida/1000);
        //                             break;
        //                             case 'Kilolitro':
        //                                 $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida/1000000);
        //                             break;
        //                         }
        //                     break;
        //                     case "Litro":
        //                         switch($nombreUnidadMedidaAlimento){
        //                             case 'Mililitro':
        //                                 $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida*1000);
                                    
        //                             break;
        //                             case 'Kilolitro':
        //                                 $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida/1000);
        //                             break;
        //                         }
        //                     break;
        //                     case "Kilolitro":
        //                         switch($nombreUnidadMedidaAlimento){
        //                             case 'Mililitro':
        //                                 $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida*1000000);
        //                             break;
        //                             case 'Litro':
        //                                 $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida*1000);
        //                             break;
        //                         }
        //                     break;
        //                     case "Miligramo":
        //                         switch($nombreUnidadMedidaAlimento){
        //                             case 'Gramo':
        //                                 $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida/1000);
        //                             break;
        //                             case 'Kilogramo':
        //                                 $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida/1000000);
        //                             break;
        //                         }
        //                     break;
        //                     case "Gramo":
        //                         switch($nombreUnidadMedidaAlimento){
        //                             case 'Miligramo':
        //                                 $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida*1000);
        //                             break;
        //                             case 'Kilogramo':
        //                                 $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida/1000);
        //                             break;
        //                         }
        //                     break;
        //                     case "Kilogramo":
        //                         switch($nombreUnidadMedidaAlimento){
        //                             case 'Miligramo':
        //                                 $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida*1000000);
        //                             break;
        //                             case 'Gramo':
        //                                 $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida*1000);
        //                             break;
        //                         }
        //                     break;    
        //                 }

        //             }
        //             $alimentoPorComida->update();

        //             //Busco la comida y actualizo los costos
        //             $comida = Comida::FindOrFail($alimentoPorComida->ComidaId);
        //             $comida->ComidaCostoTotal -= $costoViejo;
        //             $comida->ComidaCostoTotal += $alimentoPorComida->AlimentoPorComidaCostoTotal;
        //             $comida->Update();
        //             //Busco los detalles donde fue asignada esa comida
        //             $comidasPorTipoPaciente = ComidaPorTipoPaciente::where('ComidaId','=',$comida->ComidaId)->get();
        //             foreach($comidasPorTipoPaciente as $comidaPorTipoPaciente){
        //                 //Actualizo el costo de los detalles donde estaba asignada esa comida
        //                 $comidaPorTipoPaciente->ComidaPorTipoPacienteCostoTotal -= $costoViejo;
        //                 $comidaPorTipoPaciente->ComidaPorTipoPacienteCostoTotal += $alimentoPorComida->AlimentoPorComidaCostoTotal;
        //                 $comidaPorTipoPaciente->Update();
        //                 //Busco el tipo de menu y actualizo el costo
        //                 $detalleMenuTipoPaciente = DetalleMenuTipoPaciente::FindOrFail($comidaPorTipoPaciente->DetalleMenuTipoPacienteId);
        //                 $detalleMenuTipoPaciente->DetalleMenuTipoPacienteCostoTotal -= $costoViejo;
        //                 $detalleMenuTipoPaciente->DetalleMenuTipoPacienteCostoTotal += $alimentoPorComida->AlimentoPorComidaCostoTotal;
        //                 $detalleMenuTipoPaciente->Update();
        //                 //Busco el Menu para actualizar el costo
        //                 $menu = Menu::FindOrFail($detalleMenuTipoPaciente->MenuId);
        //                 $menu->MenuCostoTotal -= $costoViejo;
        //                 $menu->MenuCostoTotal += $alimentoPorComida->AlimentoPorComidaCostoTotal;
        //                 $resultado = $menu->update();
        //             }


        //         }
        //     }
        // }
        // if ($resultado) {
        //     return response()->json(['success' => 'true']);
        // }else{
        //     return response()->json(['success'=>'false']);
        // }

 
    }


    public function destroy($id)
    {

        $alimentoPorProveedor =AlimentoPorProveedor::findOrFail($id);

        /*-------------------------Actualizar costos---------------------------------*/

        // Actualizar costo total de despensa
        $alimento = Alimento::FindOrFail($alimentoPorProveedor->AlimentoId);
        $alimento->AlimentoCantidadTotal -= $alimentoPorProveedor->AlimentoPorProveedorCantidad;
        $alimento->AlimentoCostoTotal -= $alimentoPorProveedor->AlimentoPorProveedorCantidad * $alimentoPorProveedor->AlimentoPorProveedorCosto;
        $resultado = $alimento->update();
        $resultado = $alimentoPorProveedor->delete();
        /*--------------Actualizo costos de menu y comida--------------*/
        //OBTENGO EL COSTO NUEVO
        //Ejemplo:      cantidad= 2kg pollo -- costoTotal=  $400 -- costoPorKilo = $200 
        $cantidadTotal = $alimento->AlimentoCantidadTotal;
        $costoTotal = $alimento->AlimentoCostoTotal;
        if($cantidadTotal != 0){
            $costoPorUnidadMedida = $costoTotal / $cantidadTotal;

            //Obtengo el nombre de la unidad de medida en la que esta guardado el alimento en despensa
            $unidadMedidaAlimento = UnidadMedida::FindOrFail($alimento->UnidadMedidaId);
            $nombreUnidadMedidaAlimento = $unidadMedidaAlimento->UnidadMedidaNombre;

            //Busco todas las comidas donde aparezca ese alimento
            $alimentosPorComida = AlimentoPorComida::where('AlimentoId','=',$alimento->AlimentoId)->get();
            //Recorro los detalles para encontrar las comidas donde el alimento aparece
            if(!$alimentosPorComida->isEmpty()){
                foreach($alimentosPorComida as $alimentoPorComida){
                    //GUARDO EL COSTO VIEJO
                    $costoViejo = $alimentoPorComida->AlimentoPorComidaCostoTotal;

                    //Busco la unidad de medida en la que esta el alimento en cada detalle
                    $unidadMedidaDetalle = UnidadMedida::FindOrFail($alimentoPorComida->UnidadMedidaId);
                    $nombreUnidadMedidaDetalle = $unidadMedidaDetalle->UnidadMedidaNombre;

                    /*--------------OBTENGO EL COSTO DEL ALIMENTO EN CADA LINEA DE DETALLE NUEVO----------------*/
                    $alimentoPorComidaCantidadNeto = $alimentoPorComida->AlimentoPorComidaCantidadNeto;
                    if( $nombreUnidadMedidaDetalle == $nombreUnidadMedidaAlimento ){

                        $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * $costoPorUnidadMedida;
                
                    }else{

                        switch($nombreUnidadMedidaDetalle){
                            case "Mililitro":
                                switch($nombreUnidadMedidaAlimento){
                                    case 'Litro':
                                        $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida/1000);
                                    break;
                                    case 'Kilolitro':
                                        $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida/1000000);
                                    break;
                                }
                            break;
                            case "Litro":
                                switch($nombreUnidadMedidaAlimento){
                                    case 'Mililitro':
                                        $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida*1000);
                                    
                                    break;
                                    case 'Kilolitro':
                                        $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida/1000);
                                    break;
                                }
                            break;
                            case "Kilolitro":
                                switch($nombreUnidadMedidaAlimento){
                                    case 'Mililitro':
                                        $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida*1000000);
                                    break;
                                    case 'Litro':
                                        $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida*1000);
                                    break;
                                }
                            break;
                            case "Miligramo":
                                switch($nombreUnidadMedidaAlimento){
                                    case 'Gramo':
                                        $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida/1000);
                                    break;
                                    case 'Kilogramo':
                                        $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida/1000000);
                                    break;
                                }
                            break;
                            case "Gramo":
                                switch($nombreUnidadMedidaAlimento){
                                    case 'Miligramo':
                                        $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida*1000);
                                    break;
                                    case 'Kilogramo':
                                        $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida/1000);
                                    break;
                                }
                            break;
                            case "Kilogramo":
                                switch($nombreUnidadMedidaAlimento){
                                    case 'Miligramo':
                                        $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida*1000000);
                                    break;
                                    case 'Gramo':
                                        $alimentoPorComida->AlimentoPorComidaCostoTotal = $alimentoPorComidaCantidadNeto * ($costoPorUnidadMedida*1000);
                                    break;
                                }
                            break;    
                        }

                    }
                    $alimentoPorComida->update();

                    //Busco la comida y actualizo los costos
                    $comida = Comida::FindOrFail($alimentoPorComida->ComidaId);
                    $comida->ComidaCostoTotal -= $costoViejo;
                    $comida->ComidaCostoTotal += $alimentoPorComida->AlimentoPorComidaCostoTotal;
                    $comida->Update();
                    //Busco los detalles donde fue asignada esa comida
                    $comidasPorTipoPaciente = ComidaPorTipoPaciente::where('ComidaId','=',$comida->ComidaId)->get();
                    foreach($comidasPorTipoPaciente as $comidaPorTipoPaciente){
                        //Actualizo el costo de los detalles donde estaba asignada esa comida
                        $comidaPorTipoPaciente->ComidaPorTipoPacienteCostoTotal -= $costoViejo;
                        $comidaPorTipoPaciente->ComidaPorTipoPacienteCostoTotal += $alimentoPorComida->AlimentoPorComidaCostoTotal;
                        $comidaPorTipoPaciente->Update();
                        //Busco el tipo de menu y actualizo el costo
                        $detalleMenuTipoPaciente = DetalleMenuTipoPaciente::FindOrFail($comidaPorTipoPaciente->DetalleMenuTipoPacienteId);
                        $detalleMenuTipoPaciente->DetalleMenuTipoPacienteCostoTotal -= $costoViejo;
                        $detalleMenuTipoPaciente->DetalleMenuTipoPacienteCostoTotal += $alimentoPorComida->AlimentoPorComidaCostoTotal;
                        $detalleMenuTipoPaciente->Update();
                        //Busco el Menu para actualizar el costo
                        $menu = Menu::FindOrFail($detalleMenuTipoPaciente->MenuId);
                        $menu->MenuCostoTotal -= $costoViejo;
                        $menu->MenuCostoTotal += $alimentoPorComida->AlimentoPorComidaCostoTotal;
                        $resultado = $menu->update();
                    }
                }
            }
        }
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}