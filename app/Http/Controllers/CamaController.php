<?php

namespace App\Http\Controllers;

use App\Cama;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\CamaRequest;

class CamaController extends Controller
{

    public function index(Request $request) //req: piezaId
    { 
        if($request->ajax()){
            try{
                $camas = Cama::where('PiezaId',$request->get('piezaId'))->where('CamaEstado',1)->get();
                if ($camas) {
                    return response()->json(['success' => $camas]);
                }else{
                    return response()->json(['success'=>'false']);
                }
            }catch(Exception $ex){
                return response()->json([
                    'error' => $ex->getMessage()
                ], 500);
            }
        }
    }
    public function create()
    { }

    public function store(CamaRequest $request)
    {
        $cama = New Cama();
        $cama->CamaNumero = $request['camaNumero'];
        $cama->CamaEstado = 1;
        $cama->PiezaId = $request['piezaId'];
        $resultado = $cama->save();
        if ($resultado) {
            return response()->json(['success' => $cama]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
    public function show($id)
    {    }


    public function edit($id)
    { }

    //Lo utilizo solamente para cambiar el estado de la cama
    public function update(Request $request, $id)
    {
        $cama = Cama::FindOrFail($id);
        if($cama->CamaEstado == 0){
            $cama->CamaEstado = 1;
        }else{
            $cama->CamaEstado = 0;
        }
        $resultado = $cama->update();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function destroy($id)
    {
        $cama = Cama::FindOrFail($id);
        $cama->CamaEstado = 0;
        $resultado = $cama->Update();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}
