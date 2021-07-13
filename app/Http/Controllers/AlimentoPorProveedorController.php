<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AlimentoPorProveedor;
use App\Alimento;
use App\UnidadMedida;
use App\AlimentoPorComida;
use App\Comida;
use App\ComidaPorTipoPaciente;
use App\DetalleMenuTipoPaciente;
use App\Menu;
use App\Http\Requests\AlimentoPorProveedorRequest;

class AlimentoPorProveedorController extends Controller
{

    public function index()
    { }

    public function create()
    { }

    public function store(AlimentoPorProveedorRequest $request)
    {
        //Creo el nuevo detalle del alimento por proveedor 
        $datos = $request->all();
        $alimento = Alimento::FindOrFail($datos['alimentoId']);
        $alimentoPorProveedor =new AlimentoPorProveedor();
        $alimentoPorProveedor->ProveedorId = $datos['proveedor'];
        $alimentoPorProveedor->AlimentoId = $datos['alimentoId'];
        $alimentoPorProveedor->AlimentoPorProveedorVencimiento=$datos['vencimiento'];
        $alimentoPorProveedor->AlimentoPorProveedorCantidad = $datos['cantidad'];
        $alimentoPorProveedor->AlimentoPorProveedorCosto = $datos['costo'];
        $alimentoPorProveedor->AlimentoPorProveedorEstado = 1;
        $resultado = $alimentoPorProveedor->save();
        // Actualizar costo total de despensa
        $alimento->AlimentoCantidadTotal += $alimentoPorProveedor->AlimentoPorProveedorCantidad;
        $resultado = $alimento->update();
        if ($resultado) {
            return response()->json(['success' => 'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function show($id)
    { }

    public function edit($id)
    { }

    public function update(Request $request, $id)
    { 
 
    }


    public function destroy($id)
    {

        $alimentoPorProveedor =AlimentoPorProveedor::findOrFail($id);

        // Actualizar costo total de despensa
        $alimento = Alimento::FindOrFail($alimentoPorProveedor->AlimentoId);
        $alimento->AlimentoCantidadTotal -= $alimentoPorProveedor->AlimentoPorProveedorCantidad;
        $alimento->update();
        $resultado = $alimentoPorProveedor->delete();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}