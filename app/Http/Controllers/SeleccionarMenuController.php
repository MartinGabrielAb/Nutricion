<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Alimento;
use App\AlimentoPorProveedor;
class SeleccionarMenuController extends Controller
{
 
    public function index()
    {
       
        $relevamientos = array();
        $relevamientosNoControlados = DB::table('relevamiento as r')
                            ->where('RelevamientoControlado',0)
                            ->where('RelevamientoEstado',1)
                            ->orderBy('RelevamientoFecha','ASC')
                            ->join('sala as s','s.SalaId','r.SalaId')
                            ->get();
        foreach ($relevamientosNoControlados as $relevamiento) {
            $arrayComidas = array();
            $comidas = DB::table('relevamientocomida as rc')
                            ->join('comida as c','c.ComidaId','rc.ComidaId')
                            ->join('tipocomida as tc','c.TipoComidaId','tc.TipoComidaId')
                            ->where('RelevamientoId',$relevamiento->RelevamientoId)
                            ->get();
            foreach($comidas as $comida){
                $comidasMismoTipo = DB::table('comida as c')
                                    ->where('TipoComidaId',$comida->TipoComidaId)
                                    ->orderBy('ComidaNombre','asc')
                                    ->get();
                $arrayComida = array(

                    'detalleRelevamientoId' => $comida->RelevamientoComidaId,
                    'comidaId' => $comida->ComidaId,
                    'comida' => $comida->ComidaNombre,
                    'comidasMismoTipo' => $comidasMismoTipo,
                    'cantidad' =>$comida->RelevamientoComidaCantidad,
                    
                );
                array_push($arrayComidas,$arrayComida);
            }
            $arrayRelevamiento = array (
                'id' => $relevamiento -> RelevamientoId,
                'fecha' => $relevamiento->RelevamientoFecha,
                'turno' => $relevamiento->RelevamientoTurno,
                'sala'  => $relevamiento->SalaNombre,
                'pseudonimo' => $relevamiento->SalaPseudonimo,
                'comidas' => $arrayComidas,
            );
            array_push($relevamientos,$arrayRelevamiento);
        }
        return view('seleccionarmenu.principal',compact('relevamientos'));
    }

    public function create()
    { }



    public function store(Request $request)
    {
        $data = json_decode($request['data']);
        DB::beginTransaction();
        try{
            $noHabiaStock = array();
            // [Elemento 0 => id del detalle,Elemento 1 => id comida,Elemento 2 => porciones requeridas ]
            foreach($data as $dato){
                $detalleId = $dato[0]; 
                $comidaId = $dato[1]; 
                $porciones = $dato[2];
                $alcanzo = $this->descontarStock($comidaId,$porciones);
                if(!$alcanzo) array_push($noHabiaStock,$detalleId);
            }
            if(count($noHabiaStock) == 0){
                DB::commit();
                return response()->json(['success'=> 'true']);
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
    private function descontarStock($comidaId , $porciones){
        $alimentosPorComida = DB::table('alimentoporcomida as apc')
                    ->where('ComidaId',$comidaId)
                    ->where('AlimentoPorComidaEstado',1)
                    ->get();
        foreach($alimentosPorComida as $alimentoPorComida){
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
                foreach($alimentoPorProveedor as $alimentoPorProveedor){
                    if($cantidad == 0){
                        break;
                    }
                    $disponible = $alimentoPorProveedor->AlimentoPorProveedorCantidad-$alimentoPorProveedor->AlimentoPorProveedorCantidadUsada;
                    $diferencia = $cantidad - $disponible;
                    //Si es mayor a 0 es porque no me alcanzo lo de ese proveedor
                    if($diferencia>=0){
                        $alimento->AlimentoCantidadTotal -= $disponible;
                        $cantidad = $diferencia;
                        $alimentoPorProveedor->AlimentoPorProveedorCantidadUsada += $disponible;
                        $alimentoPorProveedor->AlimentoPorProveedorEstado = 0;
                    }else{
                        $alimento->AlimentoCantidadTotal -=$cantidad;
                        $alimentoPorProveedor->AlimentoPorProveedorCantidadUsada += $cantidad;
                        $cantidad = 0;
                    }
                    $alimentoPorProveedor->update();
                    $alimento->update();
                }
                return true;
            }
        } 
    }
    public function show(Request $request ,$id)
    {
           
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
