<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Nutriente;
use Exception;
use Illuminate\Http\Request;
use App\ComidaPorTipoPaciente;
use App\DetalleMenuTipoPaciente;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MenuPorTipoRequest;

class MenuPorTipoPacienteController extends Controller
{
    public function index(Request $request)//$request: menu, tipopaciente
    {
        //retorna todas las comidas del menu y tipopaciente ingresados por request ajax
        if($request->ajax()){
            if($request->get('menu') && $request->get('tipopaciente')){
                try{
                    $menuportipopaciente = 
                        DB::table('detallemenutipopaciente')
                            ->where('MenuId', $request->menu)
                            ->where('TipoPacienteId', $request->tipopaciente)
                            ->first();
                    if($menuportipopaciente){
                        $comidasportipopaciente = 
                            DB::table('comidaportipopaciente as cptp')
                                ->join('comida as c','c.ComidaId','cptp.ComidaId')
                                ->where('cptp.DetalleMenuTipoPacienteId',$menuportipopaciente->DetalleMenuTipoPacienteId)
                                ->get();
                    }else{
                        return response()->json(['success' => []]);    
                    }
                    return response()->json(['success' => $comidasportipopaciente]);
                }catch(Exception $ex){
                    return response()->json([
                        'error' => $ex->getMessage()
                    ], 500);
                }
            }
        }
    }

    public function store(MenuPorTipoRequest $request)
    {
        $detalleMenu = new DetalleMenuTipoPaciente();
        $detalleMenu->MenuId = $request['menuId'];
        $detalleMenu->TipoPacienteId = $request['tipoPaciente'];
        // $detalleMenu->DetalleMenuTipoPacienteCostoTotal = 0;  
        $resultado = $detalleMenu->save();
        if ($resultado) {
            return response()->json(['success' => 'true']);
        }else{
            return response()->json(['success'=>'false']);
        }  
    }


    public function show(Request $request,$id)
    {
        if($request->ajax()){
            $comidas = DB::table('comidaportipopaciente as c')
                                ->join('comida as com','com.ComidaId','c.ComidaId')
                                ->join('tipocomida as tc','tc.TipoComidaId','com.TipoComidaId')
								->where('DetalleMenuTipoPacienteId',$id);
            return DataTables::of($comidas)			
                                ->addColumn('btn','comidaportipopaciente/actions')
                                ->rawColumns(['btn'])
                                ->toJson();
        }

        $menu = DB::table('detallemenutipopaciente as d')
                    ->join('tipopaciente as t','t.TipoPacienteId','d.TipoPacienteId')        
                    ->where('DetalleMenuTipoPacienteId',$id)
                    ->first();
        $tiposcomida = DB::table('tipocomida')
                        ->where('TipoComidaEstado',1)
                        ->get();
        $nutrientes = Nutriente::All();

        return view('comidaportipopaciente.principal',compact('menu','tiposcomida','nutrientes'));
    }

    public function destroy($id)
    {
        $detalleMenuTipoPaciente = DetalleMenuTipoPaciente::FindOrFail($id);
        $comidasPorTipoPaciente = ComidaPorTipoPaciente::where('DetalleMenuTipoPacienteId','=',$id)->get();
        foreach($comidasPorTipoPaciente as $detalle){
            $detalle->delete();
        }
        $menu = Menu::FindOrFail($detalleMenuTipoPaciente->MenuId);
        // $menu->MenuCostoTotal -= $detalleMenuTipoPaciente->DetalleMenuTipoPacienteCostoTotal;
        $menu->update();
        $resultado = $detalleMenuTipoPaciente->delete();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}
