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
use App\Http\Requests\AlimentoPorComidaRequest;
use DB;
class AlimentoPorComidaController extends Controller
{

 
    public function index()
    {    }
    public function create()
    {   }

    public function store(AlimentoPorComidaRequest $request)
    {
        $datos = $request->all();
        $comida = Comida::FindOrFail($datos['comidaId']);
        $detalle = new AlimentoPorComida();
        $detalle->ComidaId = $datos['comidaId'];
        $detalle->AlimentoId = $datos['alimentoId'];
        $detalle->AlimentoPorComidaCantidadNeto = $datos['cantidadNeto'];
        $nombreUnidad = $datos['unidadMedida'];
        $alimento = DB::table('alimento as a')
                            ->where('AlimentoId',$detalle->AlimentoId)
                            ->join('unidadmedida as u','u.UnidadMedidaId','a.UnidadMedidaId')    
                            ->first();
        if($alimento->UnidadMedidaNombre == 'Litro') $nombreUnidad = 'cm3';
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
                                $cantidadNeto = $cantidadNeto/1000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                                // $cantidadNeto = $cantidadNeto;  
                                // $cantidadNeto = $cantidadNeto/$alimento->AlimentoEquivalenteGramos;
                                // $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                            break;
                            case 'Unidad':  
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                                $detalle->UnidadMedidaId = $unidadMedidaAlimento->UnidadMedidaId;
                            break;
 
                        }
                    break;
                    case "cm3":
                        switch($unidadMedidaAlimento->UnidadMedidaNombre){
                            
                            case 'Litro':
                                $cantidadNeto = $cantidadNeto/1000;
                                $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                                // $cantidadNeto = $cantidadNeto;  
                                // $cantidadNeto = $cantidadNeto/$alimento->AlimentoEquivalenteGramos;
                                // $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
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
        $comida->ComidaCostoTotal += $detalle->AlimentoPorComidaCostoTotal;
        $comida->Update();
        $resultado = $detalle->save();
        if ($resultado) {
            return response()->json(['success' => 'true']);
        }else{
            return response()->json(['success'=>'false']);
        }

    }

    //Utilizo el show para mostrar los nutrientes de los alimentos
    public function show($id)
    {
        $alimentosPorComida = DB::table('alimentoporcomida as a')
						->join('alimento as alim','alim.AlimentoId','a.AlimentoId')
                        ->join('unidadmedida as u','u.UnidadMedidaId','a.UnidadMedidaId')
						->where('ComidaId',$id)
                        ->orderBy('AlimentoNombre','asc')
						->get();
		$alimentos=array();
		foreach ($alimentosPorComida as $alimentoPorComida) {
			$nutrientesPorAlimento = DB::table('nutrienteporalimento as npa')
						->where('AlimentoId',$alimentoPorComida->AlimentoId)
                        ->join('nutriente as n','n.NutrienteId','npa.NutrienteId')
						->get();
			$nutrientes = array();
			if($alimentoPorComida->UnidadMedidaNombre == 'Unidad' ) {
				foreach ($nutrientesPorAlimento as $nutrientePorAlimento) {
					array_push($nutrientes,round($nutrientePorAlimento->NutrientePorAlimentoValor * $alimentoPorComida->AlimentoPorComidaCantidadNeto,2));
				}
			}else{
				foreach ($nutrientesPorAlimento as $nutrientePorAlimento) {
					array_push($nutrientes, round($nutrientePorAlimento->NutrientePorAlimentoValor/100 * $alimentoPorComida->AlimentoPorComidaCantidadNeto,2));
				}
			}
			$alimento = array(  'cantidadAlimento'=> $alimentoPorComida->AlimentoPorComidaCantidadNeto,
								'nombreAlimento'  => $alimentoPorComida->AlimentoNombre,
							    'nutrientes'      =>$nutrientes);
			array_push($alimentos, $alimento);
            
        }
        return $alimentos;
    }
   
    public function edit($id)
    {    }

  
    public function update(Request $request, $id)
    {
        // $detalle = AlimentoPorComida::FindOrFail($id);
        // $comida = Comida::FindOrFail($detalle->ComidaId);
        // $comida->ComidaCostoTotal -= $detalle->AlimentoPorComidaCostoTotal;
        // $costoViejo = $detalle->AlimentoPorComidaCostoTotal;
       
        // $datos = $request->all();
        // $detalle->AlimentoId = $datos['alimentoId'];
        // $detalle->AlimentoPorComidaCantidadNeto = $datos['cantidadNeto'];
        // $nombreUnidad = $datos['selectUnidadMedida'];
        // $unidadMedida = UnidadMedida::where('UnidadMedidaNombre','=',$nombreUnidad)->first(); 
        // $detalle->UnidadMedidaId = $unidadMedida->UnidadMedidaId;
        // $alimento = Alimento::FindOrFail($detalle->AlimentoId);
        // $unidadMedidaAlimento = UnidadMedida::FindOrFail($alimento->UnidadMedidaId);
        // $cantidadNeto = $detalle->AlimentoPorComidaCantidadNeto;
        // $cantidadTotal = $alimento->AlimentoCantidadTotal;
        // $costoTotal = $alimento->AlimentoCostoTotal;
        
        // if($cantidadTotal != 0){
        //     if($unidadMedida->UnidadMedidaId == $unidadMedidaAlimento->UnidadMedidaId){
        //         $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
    
        //     }else{
        //         switch($unidadMedida->UnidadMedidaNombre){
        //             case "Mililitro":
        //                 switch($unidadMedidaAlimento->UnidadMedidaNombre){
        //                     case 'Litro':
        //                         $cantidadNeto = $cantidadNeto/1000;
        //                         $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
        //                     break;
        //                     case 'Kilolitro':
        //                         $cantidadNeto = $cantidadNeto/1000000;
        //                         $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
        //                     break;
        //                 }
        //             break;
        //             case "Litro":
        //                 switch($unidadMedidaAlimento->UnidadMedidaNombre){
        //                     case 'Mililitro':
        //                         $cantidadNeto = $cantidadNeto*1000;
        //                         $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                              
        //                     break;
        //                     case 'Kilolitro':
        //                         $cantidadNeto = $cantidadNeto/1000;
        //                         $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                             
        //                     break;
        //                 }
        //             break;
        //             case "Kilolitro":
        //                 switch($unidadMedidaAlimento->UnidadMedidaNombre){
        //                     case 'Mililitro':
        //                         $cantidadNeto = $cantidadNeto*1000000;
        //                         $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
                                
        //                     break;
        //                     case 'Litro':
        //                         $cantidadNeto = $cantidadNeto*1000;
        //                         $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
        //                     break;
        //                 }
        //             break;
        //             case "Miligramo":
        //                 switch($unidadMedidaAlimento->UnidadMedidaNombre){
        //                     case 'Gramo':
        //                         $cantidadNeto = $cantidadNeto/1000;
        //                         $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
    
        //                     break;
        //                     case 'Kilogramo':
        //                         $cantidadNeto = $cantidadNeto/1000000;
        //                         $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
        //                     break;
        //                 }
        //             break;
        //             case "Gramo":
        //                 switch($unidadMedidaAlimento->UnidadMedidaNombre){
        //                     case 'Miligramo':
        //                         $cantidadNeto = $cantidadNeto*1000;
        //                         $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
        //                     break;
        //                     case 'Kilogramo':
        //                         $cantidadNeto = $cantidadNeto/1000;
        //                         $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
        //                     break;
        //                 }
        //             break;
        //             case "Kilogramo":
        //                 switch($unidadMedidaAlimento->UnidadMedidaNombre){
        //                     case 'Miligramo':
        //                         $cantidadNeto = $cantidadNeto*1000000;
        //                         $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
        //                     break;
        //                     case 'Gramo':
        //                         $cantidadNeto = $cantidadNeto*1000;
        //                         $detalle->AlimentoPorComidaCostoTotal = $cantidadNeto * ($costoTotal/$cantidadTotal);
        //                     break;
        //                 }
        //             break;    
        //         }
        //     }
        // }
        // else{
        //     $detalle->AlimentoPorComidaCostoTotal = 0;
        // }
        // $comidasPorTipoPaciente = ComidaPorTipoPaciente::where('ComidaId',$comida->ComidaId)->get();
        // foreach($comidasPorTipoPaciente as $comidaPorTipoPaciente){
        //     $detallesMenuTipoPaciente = DetalleMenuTipoPaciente::where('DetalleMenuTipoPacienteId',$comidaPorTipoPaciente->DetalleMenuTipoPacienteId)->get();
        //     foreach($detallesMenuTipoPaciente as $detalleMenuTipoPaciente){
        //         $detalleMenuTipoPaciente->DetalleMenuTipoPacienteCostoTotal -= $costoViejo;
        //         $menu = Menu::FindOrFail($detalleMenuTipoPaciente->MenuId);
        //         $menu->MenuCostoTotal -= $costoViejo;
        //         $detalleMenuTipoPaciente->DetalleMenuTipoPacienteCostoTotal += $detalle->AlimentoPorComidaCostoTotal;
        //         $menu->MenuCostoTotal += $detalle->AlimentoPorComidaCostoTotal;
        //         $detalleMenuTipoPaciente->update();
        //         $menu->update();
        //     }

        // }
        // $comida->ComidaCostoTotal += $detalle->AlimentoPorComidaCostoTotal;
        // $comida->Update();
        // $resultado = $detalle->update();
        // if ($resultado) {
        //     return response()->json(['success' => 'true']);
        // }else{
        //     return response()->json(['success'=>'false']);
        // }
    }

    public function destroy($id)
    {
        $detalle = AlimentoPorComida::FindOrFail($id);
        $comida = Comida::FindOrFail($detalle->ComidaId);
        $comida->ComidaCostoTotal -= $detalle->AlimentoPorComidaCostoTotal;
        $comida->Update();
        $resultado = $detalle->delete();
        if ($resultado) {
            return response()->json(['success' => 'true']);
        }else{
            return response()->json(['success'=>'false']);
        }

    }
}