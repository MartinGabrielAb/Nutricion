<?php

namespace App\Http\Controllers;
use Response;
use Illuminate\Http\Request;

use DB;
class CongeladorController extends Controller
{

    public function index(Request $request){
        if($request->ajax()){
            # Ejecuta si la petición es a través de AJAX.
            $congelador = DB::table('congelador as c')
                        ->where('c.Porciones','>',0)
                        ->join('comida as com','com.ComidaId','c.ComidaId')
                        ->get();
            return datatables()->of($congelador)
                        ->addColumn('btn','congelador/actions')
                        ->rawColumns(['btn'])
                        ->toJson();
        
        }
        # Ejecuta si la petición NO es a través de AJAX.
        $comidas = DB::table('comida as c')
                     ->where('c.ComidaEstado',1)
                     ->get();
        return view('congelador.principal',compact('comidas'));
    }

    public function create($id)
    {

    }

    public function store(Request $request)
    {

    }
    public function show($id, Request $request)
    {   
        

    }

    public function edit($id) 
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {}

}
