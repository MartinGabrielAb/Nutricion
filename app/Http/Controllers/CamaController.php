<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cama;

class CamaController extends Controller
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
        return redirect('/');
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
    {   $piezaId = $request['piezaId'];
        $camas = Cama::where('PiezaId',$piezaId)->get();
        $cama = New Cama();
        $cama->PiezaId = $piezaId;
        $cama->CamaNumero = count($camas)+1;
        $cama->CamaEstado = 1;
        $resultado = $cama->save();
        if ($resultado) {
            return response()->json(['success' => 'true']);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cama = Cama::FindOrFail($id);
        if ($cama->CamaEstado ==1) {
            $cama->CamaEstado = 0;
        }else{
            $cama->CamaEstado = 1;
        }
        $resultado = $cama->Update();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }

    }
}
