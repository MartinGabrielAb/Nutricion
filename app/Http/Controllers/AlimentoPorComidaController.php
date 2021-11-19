<?php

namespace App\Http\Controllers;

use App\Comida;
use App\Alimento;
use App\UnidadMedida;
use App\AlimentoPorComida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AlimentoPorComidaRequest;
class AlimentoPorComidaController extends Controller
{

    #Utilizo el index para devolver unidad de medida bruta de un alimento
    public function index(Request $request)
    {  
        $unidad_medida = null;
        $alimento = Alimento::findorfail($request->get('alimento_id'));
        if($alimento){
            $unidad_medida = UnidadMedida::findorfail($alimento->UnidadMedidaId);
        }
        return $unidad_medida;
    }
    public function create()
    {   }

    public function store(AlimentoPorComidaRequest $request)
    {
        $datos = $request->all();
        $detalle = new AlimentoPorComida();
        $detalle->ComidaId = $datos['comidaId'];
        $detalle->AlimentoId = $datos['alimentoId'];
        $detalle->AlimentoPorComidaCantidadNeto = $datos['cantidadNeto'];
        $detalle->AlimentoPorComidaCantidadBruta = $datos['cantidad_bruta'];
        $nombreUnidad = $datos['unidadMedida'];
        $alimento = DB::table('alimento as a')
                            ->where('AlimentoId',$detalle->AlimentoId)
                            ->join('unidadmedida as u','u.UnidadMedidaId','a.UnidadMedidaId')    
                            ->first();
        if($alimento->UnidadMedidaNombre == 'Litro') $nombreUnidad = 'cm3';
        $unidadMedida = UnidadMedida::where('UnidadMedidaNombre','=',$nombreUnidad)->first(); 
        $detalle->UnidadMedidaId = $unidadMedida->UnidadMedidaId;
        $detalle->AlimentoPorComidaEstado = 1;
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
                        ->join('unidadmedida as u','u.UnidadMedidaId','alim.UnidadMedidaId')
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
        $datos = $request->all();
        $detalle = AlimentoPorComida::FindOrFail($id);
        $detalle->ComidaId = $datos['comidaId'];
        $detalle->AlimentoId = $datos['alimentoId'];
        $detalle->AlimentoPorComidaCantidadNeto = $datos['cantidadNeto'];
        $detalle->AlimentoPorComidaCantidadBruta = $datos['cantidad_bruta'];
        $nombreUnidad = $datos['unidadMedida'];
        $alimento = DB::table('alimento as a')
                            ->where('AlimentoId',$detalle->AlimentoId)
                            ->join('unidadmedida as u','u.UnidadMedidaId','a.UnidadMedidaId')    
                            ->first();
        if($alimento->UnidadMedidaNombre == 'Litro') $nombreUnidad = 'cm3';
        $unidadMedida = UnidadMedida::where('UnidadMedidaNombre','=',$nombreUnidad)->first(); 
        $detalle->UnidadMedidaId = $unidadMedida->UnidadMedidaId;
        $detalle->AlimentoPorComidaEstado = 1;
        $resultado = $detalle->update();
        if ($resultado) {
            return response()->json(['success' => 'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function destroy($id)
    {
        $detalle = AlimentoPorComida::FindOrFail($id);
        $resultado = $detalle->delete();
        if ($resultado) {
            return response()->json(['success' => 'true']);
        }else{
            return response()->json(['success'=>'false']);
        }

    }
}