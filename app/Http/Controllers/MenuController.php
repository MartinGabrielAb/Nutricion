<?php

namespace App\Http\Controllers;

use App\Menu;
use Illuminate\Http\Request;
use App\ComidaPorTipoPaciente;
use App\DetalleMenuTipoPaciente;
use Yajra\DataTables\DataTables;
use App\Http\Requests\MenuRequest;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{

    public function index(Request $request)
    {   
        if($request->ajax()){
            $menues = DB::table('menu')->where('MenuEstado',1);
            return DataTables::of($menues)			
                                ->addColumn('btn','menues/actions')
                                ->rawColumns(['btn'])
                                ->toJson();
        }
        
        return view('menues.principal');
    }


    public function store(MenuRequest $request)
    {
        $menu = new Menu();
        $menu->MenuNombre= $request['menuNombre'];
        $menu->MenuEstado = 1;
        $resultado = $menu->save();
        if ($resultado) {
            return response()->json(['success' => $menu]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function show(Request $request,$id)
    {
        if($request->ajax()){
            $detallesMenuTipoPaciente = DB::table('detallemenutipopaciente as d')
                                ->join('tipopaciente as t','t.TipoPacienteId','d.TipoPacienteId')
								->where('MenuId',$id)
                                ->get();
            return DataTables::of($detallesMenuTipoPaciente)			
                                ->addColumn('btn','detallemenutipopaciente/actions')
                                ->rawColumns(['btn'])
                                ->toJson();
        }
        $menu = Menu::FindOrFail($id);
        $tipospaciente = DB::table('tipopaciente')
                ->where('TipoPacienteEstado',1)                    
                ->get();
        return view('detallemenutipopaciente.principal',compact('menu','tipospaciente'));
    }

    public function update(MenuRequest $request, $id)
    {
        $menu = Menu::FindOrFail($id);
        $menu->MenuNombre = $request['menuNombre'];
        $resultado = $menu->update();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $detallesMenuTipoPaciente = DetalleMenuTipoPaciente::where('MenuId', '=', $menu->MenuId)->get();
        foreach ($detallesMenuTipoPaciente as $detalleMenuTipoPaciente){
            $comidasPorTipoPaciente = ComidaPorTipoPaciente::where('DetalleMenuTipoPacienteId','=',$detalleMenuTipoPaciente->DetalleMenuTipoPacienteId)->get();
            foreach ($comidasPorTipoPaciente as $comidaPorTipoPaciente){
                $comidaPorTipoPaciente->delete();
            }
            $detalleMenuTipoPaciente->delete();
        }
        $resultado = $menu->delete();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}
