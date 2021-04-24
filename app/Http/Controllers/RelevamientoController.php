<?php

namespace App\Http\Controllers;

use App\Menu;
use Exception;
use App\Relevamiento;
use App\DetalleRelevamiento;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\RelevamientoRequest;
use Illuminate\Support\Facades\DB as FacadesDB;

class RelevamientoController extends Controller
{
    public function index(Request $request)
    {
        /*---Pregunto si es una peticion ajax----*/
        if($request->ajax()){
            try{
                $relevamientos = FacadesDB::table('relevamiento as r')
                                            ->join('menu as m','m.MenuId','r.MenuId')
                                            ->where('r.RelevamientoEstado',1)
                                            ->get();
                return DataTables::of($relevamientos)
                            ->addColumn('btn','relevamientos/actions')
                             ->rawColumns(['btn'])
                             ->toJson();
            }catch(Exception $ex){
                return response()->json([
                    'error' => 'Internal server error.'
                ], 500);
            }
        }
        $menus = Menu::where('MenuEstado',1)->where('MenuParticular',0)->get();
        return view('relevamientos.principal',compact('menus'));
    }

    public function create()
    { }

    public function store(RelevamientoRequest $request)
    {
        $relevamiento = new Relevamiento;
        $relevamiento->RelevamientoEstado = 1;
        $relevamiento->RelevamientoFecha = $request->get('fecha');
        $relevamiento->MenuId = $request->get('menu');
        $resultado = $relevamiento->save();
        if ($resultado) {
            return response()->json(['success'=> $relevamiento]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function show($id)
    {
        $relevamiento = Relevamiento::findOrFail($id);
        return view('relevamientos.show',compact('relevamiento'));
    }

    public function edit($id)
    { }

    public function update(RelevamientoRequest $request, $id)
    { 
        $relevamiento = Relevamiento::findOrFail($id);
        $relevamiento->RelevamientoEstado = 1;
        $relevamiento->RelevamientoFecha = $request->get('fecha');
        $relevamiento->MenuId = $request->get('menu');
        $resultado = $relevamiento->update();
        if ($resultado) {
            return response()->json(['success'=> $relevamiento]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function destroy($id)
    {
        $relevamiento = Relevamiento::findOrFail($id);
        $detallesRelevamiento = DetalleRelevamiento::where("RelevamientoId",$relevamiento->RelevamientoId)->get();
        if($detallesRelevamiento){
            foreach ($detallesRelevamiento as $detalleRelevamiento) {
                $detalleRelevamiento->DetalleRelevamientoEstado = 0;
            }
        }
        $relevamiento->RelevamientoEstado = 0;
        $resultado = $relevamiento->update();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}