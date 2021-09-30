<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Alimento;
use App\Historial;
use App\Relevamiento;
use App\HistorialDetalleComida;
use App\HistorialDetalleAlimento;

use App\AlimentoPorProveedor;
class SeleccionarMenuController extends Controller
{
 
    public function index(Request $request)
    {
        if($request->ajax()){
            
        }
        return view('seleccionarmenu.principal');
    }

    public function create()
    { 
        
        

    }




    public function store(Request $request)
    {
        $comidas = $request['params']['data'];
        $relevamientoId = $request['params']['relevamiento'];
        DB::beginTransaction();
        try{
            $noHabiaStock = array();

            $historial = new Historial();
            $historial->RelevamientoId = $relevamientoId;
            $historial->save();
            // [Elemento 0 => comida,Elemento 1 => porciones requeridas ]
            foreach($comidas as $comida){
                $historialDetComida = new HistorialDetalleComida();
                $historialDetComida->HistorialId = $historial->HistorialId;
                $historialDetComida->ComidaNombre = $comida[0]['ComidaNombre']; 
                $historialDetComida->Porciones = $comida[1];
                $historialDetComida->save();
                $comidaId = $comida[0]['ComidaId']; 
                $porciones = $comida[1];
                $alcanzo = $this->descontarStock($comidaId,$porciones,$historialDetComida->HistorialDetalleComidaId);
                if(!$alcanzo) array_push($noHabiaStock,$comida);
            }
            if(count($noHabiaStock) == 0){
                $relevamiento = Relevamiento::findOrFail($relevamientoId);
                $relevamiento->RelevamientoControlado = 1;
                $relevamiento->update();
                DB::commit();
                return response()->json(['success'=> $historial->HistorialId]);
                
            }else{
                DB::rollback();
                return response()->json(['error'=>$noHabiaStock ]);;
            }
        }catch(Exception $e){
            DB::rollback();
            return response()->json([
                'error' => $ex->getMessage()
            ], 500);
        }
    }

    //retorna true si el stock alcanzo para esa comida
    private function descontarStock($comidaId , $porciones,$historialDetComidaId){
        $alimentosPorComida = DB::table('alimentoporcomida as apc')
                    ->where('ComidaId',$comidaId)
                    ->join('alimento as a','a.AlimentoId','apc.AlimentoId')
                    ->join('unidadmedida as u','u.UnidadMedidaId','apc.UnidadMedidaId')
                    ->where('AlimentoPorComidaEstado',1)
                    ->get();
        foreach($alimentosPorComida as $alimentoPorComida){
            $historialDetAlimento = new HistorialDetalleAlimento();
            $historialDetAlimento->HistorialDetalleComidaId = $historialDetComidaId;
            $historialDetAlimento->AlimentoNombre = $alimentoPorComida->AlimentoNombre;
            $historialDetAlimento->UnidadMedida = $alimentoPorComida->UnidadMedidaNombre;
            $historialDetAlimento->Cantidad = $alimentoPorComida->AlimentoPorComidaCantidadNeto;
            $alimento = Alimento::where('AlimentoId',$alimentoPorComida->AlimentoId)
                            ->where('AlimentoEstado',1)
                            ->first();
            //Controlo la unidad de medida
            if($alimentoPorComida->UnidadMedidaId == $alimento->UnidadMedidaId ){
                $cantidad = $alimentoPorComida->AlimentoPorComidaCantidadNeto * $porciones;
            }else{
                $cantidad = $alimentoPorComida->AlimentoPorComidaCantidadNeto/1000 * $porciones;
            }
            //Si no alcanza pongo el stock en 0 (para que las comidas siguientes no cuenten con este alimento,el rollback lo va a volver a su estado anterior)
            if($cantidad > $alimento->AlimentoCantidadTotal){                                           
                $alimento->AlimentoCantidadTotal = 0; 
                $alimento->update();                    
                return false;
            }//Si alcanza hago la logica para restar de manera correcta de alimentoporproveedor
            else{
                $alimentoPorProveedor = AlimentoPorProveedor::where('AlimentoId',$alimento->AlimentoId)
                                            ->orderBy('AlimentoPorProveedorVencimiento','ASC')
                                            ->get();
                $costo = 0;
                foreach($alimentoPorProveedor as $alimentoPorProveedor){
                    if($cantidad == 0){

                        break;
                    }
                    $disponible = $alimentoPorProveedor->AlimentoPorProveedorCantidad-$alimentoPorProveedor->AlimentoPorProveedorCantidadUsada;
                    $diferencia = $cantidad - $disponible;
                    //Si es mayor a 0 es porque no me alcanzo lo de ese proveedor
                    if($diferencia>=0){
                        $costo += $disponible * $alimento->AlimentoPorProveedorCosto;
                        $alimento->AlimentoCantidadTotal -= $disponible;
                        $cantidad = $diferencia;
                        $alimentoPorProveedor->AlimentoPorProveedorCantidadUsada += $disponible;
                        $alimentoPorProveedor->AlimentoPorProveedorEstado = 0;
                    }else{
                        $costo += $cantidad * $alimento->AlimentoPorProveedorCosto;
                        $alimento->AlimentoCantidadTotal -=$cantidad;
                        $alimentoPorProveedor->AlimentoPorProveedorCantidadUsada += $cantidad;
                        $cantidad = 0;
                    }
                   
                    $alimentoPorProveedor->update();
                    $alimento->update();
                }
                $historialDetAlimento->CostoTotal = $costo;
                $historialDetAlimento->save();
                
                return true;
            }
        } 
    }
    public function show(Request $request ,$id)
    {
        return view('seleccionarmenu.show',compact('id'));

    }

    public function edit()
    { }

    public function update($id)
    {
     
    }

    public function destroy($id)
    {
        
    }
}
