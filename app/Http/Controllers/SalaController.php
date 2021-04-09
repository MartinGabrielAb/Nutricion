<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sala;
use App\Pieza;
use App\Cama;
use App\Http\Requests\CrearSalaRequest;
use Illuminate\Support\Facades\Auth;
use DB;

class SalaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*---Pregunto si es una peticion ajax----*/
        if($request->ajax()){
            $salas = DB::table('sala')
            ->where('SalaEstado',1)
            ->get();
            return compact('salas');
        }
        $user = Auth::user();
        return view('salas.principal',compact('user'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
        return view('salas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sala = New Sala();
        $sala->SalaNombre = $request['salaNombre'];
        $sala->SalaEstado = 1;
        $resultado = $sala->save();
        if ($resultado) {
            return response()->json(['success' => $sala]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $sala = Sala::FindOrFail($id);
        return view('salas.show',compact('sala'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
                return ("edit");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sala = Sala::FindOrFail($id);
        $sala->SalaNombre = $request['salaNombre'];
        $resultado = $sala->update();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
