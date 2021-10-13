<?php

namespace App\Http\Controllers;
use DB;
use Response;

use App\Congelador;
use Illuminate\Http\Request;

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
        $comida_id = $request->get('comida_id');
        $comida_existente = Congelador::where('ComidaId',$comida_id)->first();

        if($comida_existente){
            $response = false;
        }else{
            $comida_congelada = new Congelador();
            $comida_congelada->ComidaId = $request->get('comida_id');
            $comida_congelada->Porciones = $request->get('cantidad');    
            $comida_congelada->save();
            $response = true;
        }
        return $response;
    }
    public function show($id, Request $request)
    {   
        

    }

    public function edit($id) 
    {
    }

    public function update(Request $request, $id)
    {
        $response = false;
        $comida_existente = Congelador::findorfail($id);
        if($comida_existente){
            $comida_existente->Porciones = $request->get('cantidad');
            $comida_existente->update();
            $response = true;
        }
        return $response;
    }

    public function destroy($id)
    {
        $comida_existente = Congelador::findorfail($id);
        if($comida_existente){
            $comida_existente->delete();
        }
    }

}
