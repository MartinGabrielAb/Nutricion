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
                        ->where('Porciones','>',0)
                        ->join('comida as com','com.ComidaId','c.ComidaId')
                        ->get();
            if($congelador){
            return datatables()->of($congelador)
                        ->addColumn('btn','congelador/actions')
                        ->rawColumns(['btn'])
                        ->toJson();
            }
        }
        # Ejecuta si la petición NO es a través de AJAX.
        return view('congelador.principal');
    }

    public function create($id)
    {

    }

    public function store(Request $request)
    {}
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
