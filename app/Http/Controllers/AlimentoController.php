<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alimento;
use App\AlimentoPorProveedor;
use App\UnidadMedida;
use App\Proveedor;
use App\NutrientePorAlimento;

class AlimentoController extends Controller
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
        $unidadesMedida = UnidadMedida::all();
        
        // $alimentos = Alimento::where('AlimentoEstado',1)->get();
        return view('alimentos.principal',compact('unidadesMedida'));
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

        $datos = $request->all();
        $unidadMedida = UnidadMedida::findOrFail($datos['unidadMedidaId']);
        $alimento =new Alimento();
        $alimento->AlimentoNombre = $datos['alimentoNombre'];
        $alimento->UnidadMedidaId = $datos['unidadMedidaId'];
        if($unidadMedida->UnidadMedidaNombre == 'Litro'){
            $alimento->AlimentoEquivalenteGramos = $datos['equivalenteGramos'];
        }
        if($unidadMedida->UnidadMedidaNombre == 'Kilogramo'){
            $alimento->AlimentoEquivalenteGramos = 1000;
        }
        if($unidadMedida->UnidadMedidaNombre == 'Gramo'){
            $alimento->AlimentoEquivalenteGramos = 1;
        }
        if($unidadMedida->UnidadMedidaNombre == 'Unidad'){
            $alimento->AlimentoEquivalenteGramos = NULL;
        }
        $alimento->AlimentoEstado = 1;
        $alimento->AlimentoCantidadTotal = 0;
        $alimento->AlimentoCostoTotal = 0;
        $resultado = $alimento->save();

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
        $alimento = Alimento::findOrFail($id);
        $proveedores = Proveedor::all();
        return view('alimentos.show',compact('alimento','proveedores'));
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
        $alimento = Alimento::FindOrFail($id);
        $alimentoPorProveedor = AlimentoPorProveedor::where('AlimentoId','=',$id)->get();
        foreach ($alimentoPorProveedor as $alimentoPorProveedor) {
            $alimentoPorProveedor->delete();
        }
        $nutrientesPorAlimento = NutrientePorAlimento::where('AlimentoId','=',$id)->get();
        foreach ($nutrientesPorAlimento as $nutrientePorAlimento) {
            $nutrientePorAlimento->delete();
        }
        $resultado = $alimento->delete();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}