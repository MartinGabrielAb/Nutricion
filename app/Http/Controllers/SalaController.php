<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sala;
use App\Pieza;
use App\Cama;
use Exception;
use Illuminate\Support\Facades\DB as FacadesDB;
use Yajra\DataTables\DataTables;
use App\Http\Requests\SalaRequest;

class SalaController extends Controller
{
 
    public function index(Request $request)
    {
        /*---Pregunto si es una peticion ajax----*/
        if($request->ajax()){
            try{
                $salas = FacadesDB::table('sala')->where('SalaEstado',1);
                return DataTables::of($salas)
                            ->addColumn('btn','salas/actions')
                            ->rawColumns(['btn'])
                            ->toJson();
            }catch(Exception $ex){
                return response()->json([
                    'error' => $ex->getMessage()
                ], 500);
            }
        }
        return view('salas.principal');
    }

    public function create()
    { }

    public function store(SalaRequest $request)
    {
        $sala = New Sala();
        $sala->SalaNombre = $request['salaNombre'];
        $sala->SalaPseudonimo = $request['pseudonimo'];
        $sala->SalaEstado = 1;
        $resultado = $sala->save();
        if ($resultado) {
            return response()->json(['success' => $sala]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function show(Request $request ,$id)
    {
            /*---Pregunto si es una peticion ajax----*/
            if($request->ajax()){
                try{
                    $piezas = FacadesDB::table('pieza')
                                    ->where('SalaId', $id)
                                    ->where('PiezaEstado',1);
                    return DataTables::of($piezas)
                                ->addColumn('btn','piezas/actions')
                                ->rawColumns(['btn'])
                                ->toJson();
                }catch(Exception $ex){
                    return response()->json([
                        'error' => $ex->getMessage()
                    ], 500);
                }
            }
            $sala = Sala::FindOrFail($id);
            return view('piezas.principal',compact('sala'));
    }

    public function edit($id)
    { }

    public function update(SalaRequest $request, $id)
    {
        $sala = Sala::FindOrFail($id);
        $sala->SalaNombre = $request['salaNombre'];
        $sala->SalaPseudonimo = $request['pseudonimo'];
        $resultado = $sala->update();
        if ($resultado) {
            return response()->json(['success'=>$sala]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function destroy($id)
    {
        $sala = Sala::FindOrFail($id);
        $piezas = Pieza::where('SalaId',$sala->SalaId)->get();
        foreach ($piezas as $pieza) {
            $camas = Cama::where('PiezaId',$pieza->PiezaId)->get();
            foreach ($camas as $cama) {
                $cama->CamaEstado = 0;
                $cama->update();
            }
            $pieza->PiezaEstado = 0;
            $pieza->Update();
        }
        $sala->SalaEstado = 0;
        $resultado = $sala->Update();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}
