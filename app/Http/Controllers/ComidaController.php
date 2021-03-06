<?php

namespace App\Http\Controllers;

use App\Comida;
use App\Alimento;
use App\Nutriente;
use App\UnidadMedida;
use App\AlimentoPorComida;
use Illuminate\Http\Request;
use App\ComidaPorTipoPaciente;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ComidaRequest;


class ComidaController extends Controller
{

    public function index(Request $request)
    {
        if($request->ajax()){
            $comidas = DB::table('comida as c')
            ->join('tipocomida as t', 't.TipoComidaId', '=', 'c.TipoComidaId')
            ->where('c.ComidaEstado','=',1)
            ->get();
	        return DataTables::of($comidas)
						->addColumn('btn','comidas/actions')
	 					->rawColumns(['ComidaEstado','btn'])
	 					->toJson();
        }
        $tiposComida = DB::table('tipocomida')->where('TipoComidaEstado',1)->get();
        return view('comidas.principal',compact('tiposComida'));
    }

    
    public function create()
    { }
    
    public function store(ComidaRequest $request)
    {
        $datos = $request->all(); 
        $comida = new Comida();
        $comida->ComidaNombre = $datos['nombre'];;
        $comida->TipoComidaId = $datos['tipo'];
        $comida->ComidaEstado = 1;
        $resultado = $comida->save();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

  
    public function show(Request $request, $id)
    {
        if($request->ajax()){
            $alimentosPorComida = DB::table('alimentoporcomida as apc')
								->join('alimento as a','a.AlimentoId','apc.AlimentoId')
								->join('unidadmedida as um','um.UnidadMedidaId','apc.UnidadMedidaId')
								->where('apc.ComidaId',$id)
								->where('apc.AlimentoPorComidaEstado',1)
                                ->get();
            foreach ($alimentosPorComida as $alimentoPorComida) {
                $alimento = Alimento::findorfail($alimentoPorComida->AlimentoId);
                if($alimento){
                    $unidad_medida = UnidadMedida::findorfail($alimento->UnidadMedidaId);
                    $alimentoPorComida->UnidadMedidaBruta = $unidad_medida->UnidadMedidaNombre;
                }
            }
	        return DataTables::of($alimentosPorComida)
						->addColumn('btn','alimentosporcomida/actions')
						->rawColumns(['AlimentoPorComidaEstado','btn'])
	 					->toJson();
        }
        $alimentos = Alimento::where('AlimentoEstado',1)
                                ->orderBy('AlimentoNombre','asc')
                                ->get();
        $unidadesMedida = UnidadMedida::all();
        $comida = Comida::findOrFail($id);
        $nutrientes = Nutriente::all();
        return view('alimentosporcomida.principal',compact('comida','alimentos','unidadesMedida','nutrientes'));
    }

    // Este lo uso para traer comidas por tipo 
    //el id es el tipo de comida
    public function edit($id)
    {
        $comidas = DB::table('comida')
            ->where('TipoComidaId',intval($id))
            ->where('ComidaEstado',1)
            ->get();
        return $comidas;
    }

    public function update(ComidaRequest $request, $id)
    {
        $comida = Comida::FindOrFail($id);
        $datos = $request->all();
        $comida->ComidaNombre = $datos['nombre'];
        $comida->TipoComidaId = $datos['tipo'];
        $comidasPorTipoPaciente = ComidaPorTipoPaciente::where('ComidaId', $comida->ComidaId)->get();
        foreach($comidasPorTipoPaciente as $comidaPorTipoPaciente){
            $comidaPorTipoPaciente->TipoComidaId = $comida->TipoComidaId;
            $comidaPorTipoPaciente->update();
        }
        $resultado = $comida->update();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
    public function destroy($id)
    {
        $comida = Comida::FindOrFail($id);
        /*Elimino los alimentos que tiene dentro*/
        $alimentosPorComida = AlimentoPorComida::where('ComidaId','=',$comida->ComidaId)->get();
        foreach ($alimentosPorComida as $alimentoPorComida) {
             $alimentoPorComida->delete();
         } 
        $comidasPorTipoPaciente = ComidaPorTipoPaciente::where('ComidaId','=',$comida->ComidaId)->get();
        foreach($comidasPorTipoPaciente as $comidaPorTipoPaciente){
            $comidaPorTipoPaciente->delete();
        }
        $resultado = $comida->delete();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

}