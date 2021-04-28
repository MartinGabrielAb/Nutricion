<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pieza;
use App\Cama;
use Exception;
use Illuminate\Support\Facades\DB as FacadesDB;
use Yajra\DataTables\DataTables;
use App\Http\Requests\PiezaRequest;

class PiezaController extends Controller
{
    public function index()
    { }

    public function create()
    { }

    public function store(PiezaRequest $request)
    {
        $pieza = New Pieza();
        $pieza->PiezaNombre = $request['piezaNombre'];
        $pieza->PiezaPseudonimo = $request['pseudonimo'];
        $pieza->PiezaEstado = 1;
        $pieza->SalaId = $request['salaId'];
        $resultado = $pieza->save();
        if ($resultado) {
            return response()->json(['success' => $pieza]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function show(Request $request,$id)
    {
        if($request->ajax()){
            try{
                $camas = FacadesDB::table('cama')
                                ->where('PiezaId', $id)
                                ->get();
                return DataTables::of($camas)
                            ->addColumn('CamaEstado',function($cama){
                                if ($cama->CamaEstado == 1) {
                                    return '<td><p class="text-success">Activa</p></td>';
                                }else{
                                    return '<td><p class="text-danger">Inactiva</p></td>';
                                }
                            })
                            ->addColumn('btn','camas/actions')
                            ->rawColumns(['CamaEstado','btn'])
                            ->toJson();
            }catch(Exception $ex){
                return response()->json([
                    'error' => $ex->getMessage()
                ], 500);
            }
        }
        $pieza = Pieza::FindOrFail($id);
        return view('camas.principal',compact('pieza'));
    }


    public function edit($id)
    { }

    public function update(PiezaRequest $request, $id)
    {
        $pieza = Pieza::FindOrFail($id);
        $pieza->PiezaNombre = $request['piezaNombre'];
        $pieza->PiezaPseudonimo = $request['pseudonimo'];
        $resultado = $pieza->update();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function destroy($id)
    {
        
        $pieza = Pieza::FindOrFail($id);
        $camas = Cama::where('PiezaId',$pieza->PiezaId)->get();
        foreach ($camas as $cama) {
            $cama->CamaEstado = 0;
            $cama->Update();
        }
        $pieza->PiezaEstado = 0;
        $resultado = $pieza->Update();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}
