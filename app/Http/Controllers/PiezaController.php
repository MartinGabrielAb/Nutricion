<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pieza;
use App\Cama;
class PiezaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pieza = New Pieza();
        $pieza->PiezaNombre = $request['piezaNombre'];
        $pieza->PiezaEstado = 1;
        $pieza->SalaId = $request['salaId'];
        $resultado = $pieza->save();

        if ($resultado) {
            return response()->json(['success' => $pieza]);
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
        $pieza = Pieza::FindOrFail($id);
        return view('salas.camas',compact('pieza'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $pieza = Pieza::FindOrFail($id);
        $pieza->PiezaNombre = $request['piezaNombre'];
        $resultado = $pieza->update();
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
