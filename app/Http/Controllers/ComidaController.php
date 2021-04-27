<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoComida;
use App\Comida;
use App\ComidaPorTipoPaciente;
use App\AlimentoPorComida;
use App\DetalleMenuTipoPaciente;
use App\Menu;
use App\Alimento;
use App\UnidadMedida;

use Yajra\DataTables\DataTables;
use DB;
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
    {
        //
    }

    
    public function store(ComidaRequest $request)
    {
        $datos = $request->all(); 
        $comida = new Comida();
        $comida->ComidaNombre = $datos['nombre'];;
        $comida->TipoComidaId = $datos['tipo'];
        $comida->ComidaCostoTotal = 0;
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
	        return DataTables::of($alimentosPorComida)
						->addColumn('btn','alimentosporcomida/actions')
						->rawColumns(['AlimentoPorComidaEstado','btn'])
	 					->toJson();
        }
        $alimentos = Alimento::where('AlimentoEstado',1)->get();
        $unidadesMedida = UnidadMedida::all();
        $comida = Comida::findOrFail($id);
        return view('alimentosporcomida.principal',compact('comida','alimentos','unidadesMedida'));
    }

    public function edit($id)
    {
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
            $comidaPorTipoPaciente->ComidaId = NULL;
            $comidaPorTipoPaciente->comidaPorTipoPacienteCostoTotal -= $comida->ComidaCostoTotal;
            $detallesMenuTipoPaciente= DetalleMenuTipoPaciente::where('DetalleMenuTipoPacienteId','=',$comidaPorTipoPaciente->DetalleMenuTipoPacienteId)->get();
            foreach($detallesMenuTipoPaciente as $detalleMenuTipoPaciente){
                $detalleMenuTipoPaciente->DetalleMenuTipoPacienteCostoTotal -= $comida->ComidaCostoTotal;
                
                $menu = Menu::findOrFail($detalleMenuTipoPaciente->MenuId);
                $menu->MenuCostoTotal -= $comida->ComidaCostoTotal; 
                 
                $detalleMenuTipoPaciente->update();
                $menu->update();
            }
            $comidaPorTipoPaciente->update();
        }
        $resultado = $comida->delete();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}