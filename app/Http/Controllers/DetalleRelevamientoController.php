<?php

namespace App\Http\Controllers;

use Exception;
use App\Paciente;
use App\RelevamientoComida;
use App\DetalleRelevamiento;
use Illuminate\Http\Request;
use App\DetRelevamientoPorComida;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DetalleRelevamientoController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('America/Argentina/Salta');
    }
    public function index(Request $request)//request: relevamientoId
    { }

    public function create()
    { }

    public function store(Request $request)//request: relevamiento, paciente, cama, diagnostico, observaciones, menu, tipopaciente, acompaniante, vajilladescartable, user
    {
        $paciente = Paciente::where('PacienteCuil',$request->get('paciente'))->where('PacienteEstado','!=',-1)->first();
        $detalleRelevamiento = new DetalleRelevamiento;
        $detalleRelevamiento->DetalleRelevamientoEstado = 1;
        $detalleRelevamiento->RelevamientoId = $request->get('relevamiento');
        $detalleRelevamiento->PacienteId = $paciente->PacienteId;
        $detalleRelevamiento->CamaId = $request->get('cama');
        $detalleRelevamiento->DetalleRelevamientoDiagnostico = $request->get('diagnostico');
        $detalleRelevamiento->DetalleRelevamientoObservaciones = $request->get('observaciones');
        $detalleRelevamiento->MenuId = $request->get('menu');
        $detalleRelevamiento->TipoPacienteId = $request->get('tipopaciente');
        if($request->get('acompaniante') == 'true'){
            $detalleRelevamiento->DetalleRelevamientoAcompaniante = 1;
        }else{
            $detalleRelevamiento->DetalleRelevamientoAcompaniante = 0;
        }
        if($request->get('vajilladescartable') == 'true'){
            $detalleRelevamiento->DetalleRelevamientoVajillaDescartable = 1;
        }else{
            $detalleRelevamiento->DetalleRelevamientoVajillaDescartable = 0;
        }
        if($request->get('agregado') == 'true'){
            $detalleRelevamiento->DetalleRelevamientoAgregado = 1;
        }else{
            $detalleRelevamiento->DetalleRelevamientoAgregado = 0;
        }
        $detalleRelevamiento->UserId = $request->get('user');
        $resultado = $detalleRelevamiento->save();
        foreach ($request->get('comidas') as $key => $comidaId) {
            $detRelevamientoPorComida = new DetRelevamientoPorComida;
            $detRelevamientoPorComida->DetalleRelevamientoId = $detalleRelevamiento->DetalleRelevamientoId;
            $detRelevamientoPorComida->ComidaId = $comidaId;
            $detRelevamientoPorComida->save();

            $relevamientoComida = RelevamientoComida::where('RelevamientoId',$detalleRelevamiento->RelevamientoId)
                                                    ->where('ComidaId',$comidaId)
                                                    ->first();
            if($relevamientoComida){
                $relevamientoComida = RelevamientoComida::findOrFail($relevamientoComida->RelevamientoComidaId);
                $relevamientoComida->RelevamientoComidaCantidad = $relevamientoComida->RelevamientoComidaCantidad + 1;
                $relevamientoComida->update();
            }else{
                $relevamientoComida = new RelevamientoComida;
                $relevamientoComida->RelevamientoId = $detalleRelevamiento->RelevamientoId;
                $relevamientoComida->ComidaId = $comidaId;
                $relevamientoComida->RelevamientoComidaCantidad = 1;
                $relevamientoComida->save();
            }
        }
        if ($resultado) {
            return response()->json(['success'=>$request->get('cama')]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function show($id,Request $request)
    { 
        $detalleRelevamiento = 
                    DB::table('detallerelevamiento as dr')
                    ->join('paciente as pa','pa.PacienteId','dr.PacienteId')
                    ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                    ->join('cama as c','c.CamaId','dr.CamaId')
                    ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                    ->join('users as u','u.id','dr.UserId')
                    ->join('menu as m','m.MenuId','dr.MenuId')
                    ->where('dr.CamaId',$request->get('camaId'))
                    ->where('dr.RelevamientoId',$request->get('relevamientoId'))
                    ->where('dr.DetalleRelevamientoEstado','!=',-1)
                    ->select('dr.DetalleRelevamientoId',
                            DB::raw('DATE_FORMAT(dr.updated_at, "%H:%i:%s") as DetalleRelevamientoHora'),'dr.RelevamientoId',
                            'dr.DetalleRelevamientoDiagnostico',
                            'dr.DetalleRelevamientoAcompaniante',
                            'dr.DetalleRelevamientoVajillaDescartable',
                            'dr.DetalleRelevamientoAgregado',
                            'dr.DetalleRelevamientoEstado','dr.DetalleRelevamientoObservaciones',
                            'm.MenuNombre','m.MenuId',
                            'pa.PacienteId','pa.PacienteNombre','pa.PacienteApellido','pa.PacienteCuil',
                            'tp.TipoPacienteNombre','tp.TipoPacienteId',
                            'c.CamaNumero','pi.PiezaPseudonimo','c.CamaId',
                            'u.name as Relevador','u.id as UserId')
                    ->orderby('dr.updated_at','desc')
                    ->first();
        if(!$detalleRelevamiento)
        {
            $detalleRelevamiento = 
                    DB::table('detallerelevamiento as dr')
                    ->join('paciente as pa','pa.PacienteId','dr.PacienteId')
                    ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                    ->join('cama as c','c.CamaId','dr.CamaId')
                    ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                    ->join('users as u','u.id','dr.UserId')
                    ->join('menu as m','m.MenuId','dr.MenuId')
                    ->where('dr.CamaId',$request->get('camaId'))
                    ->where('dr.DetalleRelevamientoEstado','!=',-1)
                    ->select('dr.DetalleRelevamientoId',
                            DB::raw('DATE_FORMAT(dr.updated_at, "%H:%i:%s") as DetalleRelevamientoHora'),'dr.RelevamientoId',
                            'dr.DetalleRelevamientoDiagnostico',
                            'dr.DetalleRelevamientoAcompaniante',
                            'dr.DetalleRelevamientoVajillaDescartable',
                            'dr.DetalleRelevamientoAgregado',
                            'dr.DetalleRelevamientoEstado','dr.DetalleRelevamientoObservaciones',
                            'm.MenuNombre','m.MenuId',
                            'pa.PacienteId','pa.PacienteNombre','pa.PacienteApellido','pa.PacienteCuil',
                            'tp.TipoPacienteNombre','tp.TipoPacienteId',
                            'c.CamaNumero','pi.PiezaPseudonimo','c.CamaId',
                            'u.name as Relevador','u.id as UserId')
                    ->orderby('dr.updated_at','desc')
                    ->first();
        }
        return response()->json(['success'=>$detalleRelevamiento]);
    }

    public function edit($id)
    { }

    public function update(Request $request, $id)//request: relevamiento, paciente, cama, diagnostico, observaciones, menu, tipopaciente, acompaniante, vajilladescartable, user
    {
        // dd($id);
        //actualizo estado del relevamiento que se está queriendo editar para guardarlo como historial del paciente
        
        $detalleRelevamiento = DetalleRelevamiento::findOrFail($id);
        $detalleRelevamiento->DetalleRelevamientoEstado = 0;
        $detallesRelevamientoPorComida = DetRelevamientoPorComida::where('DetalleRelevamientoId',$detalleRelevamiento->DetalleRelevamientoId)->get();
        if($detallesRelevamientoPorComida){
            foreach ($detallesRelevamientoPorComida as $detalleRelevamientoPorComida) {
                $relevamientoComida = RelevamientoComida::where('RelevamientoId',$detalleRelevamiento->RelevamientoId)
                                                        ->where('ComidaId',$detalleRelevamientoPorComida->ComidaId)
                                                        ->first();
                if($relevamientoComida){
                    $relevamientoComida = RelevamientoComida::findOrFail($relevamientoComida->RelevamientoComidaId);
                    $relevamientoComida->RelevamientoComidaCantidad = $relevamientoComida->RelevamientoComidaCantidad - 1;
                    $relevamientoComida->update();
                }
            }
        }
        $detalleRelevamiento->update();
        $paciente = Paciente::where('PacienteCuil',$request->get('paciente'))->where('PacienteEstado','!=',-1)->first();
        $detalleRelevamiento = new DetalleRelevamiento;
        $detalleRelevamiento->DetalleRelevamientoEstado = 1;
        $detalleRelevamiento->RelevamientoId = $request->get('relevamiento');
        $detalleRelevamiento->PacienteId = $paciente->PacienteId;
        $detalleRelevamiento->CamaId = $request->get('cama');
        $detalleRelevamiento->DetalleRelevamientoDiagnostico = $request->get('diagnostico');
        $detalleRelevamiento->DetalleRelevamientoObservaciones = $request->get('observaciones');
        $detalleRelevamiento->MenuId = $request->get('menu');
        $detalleRelevamiento->TipoPacienteId = $request->get('tipopaciente');
        if($request->get('acompaniante') == 'true'){
            $detalleRelevamiento->DetalleRelevamientoAcompaniante = 1;
        }else{
            $detalleRelevamiento->DetalleRelevamientoAcompaniante = 0;
        }
        if($request->get('vajilladescartable') == 'true'){
            $detalleRelevamiento->DetalleRelevamientoVajillaDescartable = 1;
        }else{
            $detalleRelevamiento->DetalleRelevamientoVajillaDescartable = 0;
        }
        if($request->get('agregado') == 'true'){
            $detalleRelevamiento->DetalleRelevamientoAgregado = 1;
        }else{
            $detalleRelevamiento->DetalleRelevamientoAgregado = 0;
        }
        $detalleRelevamiento->UserId = $request->get('user');
        //seteo un segundo más la última acualización porque uso este campo para obtener el último registro editado. (conflicto con el detalle relevamiento antiguo)
        $detalleRelevamiento->updated_at = date("m/d/Y h:i:s a", time() + 1);
        $resultado = $detalleRelevamiento->save();
        foreach ($request->get('comidas') as $key => $comidaId) {
            $detRelevamientoPorComida = new DetRelevamientoPorComida;
            $detRelevamientoPorComida->DetalleRelevamientoId = $detalleRelevamiento->DetalleRelevamientoId;
            $detRelevamientoPorComida->ComidaId = $comidaId;
            $detRelevamientoPorComida->save();

            $relevamientoComida = RelevamientoComida::where('RelevamientoId',$detalleRelevamiento->RelevamientoId)
                                                    ->where('ComidaId',$comidaId)
                                                    ->first();
            if($relevamientoComida){
                $relevamientoComida = RelevamientoComida::findOrFail($relevamientoComida->RelevamientoComidaId);
                $relevamientoComida->RelevamientoComidaCantidad = $relevamientoComida->RelevamientoComidaCantidad + 1;
                $relevamientoComida->update();
            }else{
                $relevamientoComida = new RelevamientoComida;
                $relevamientoComida->RelevamientoId = $detalleRelevamiento->RelevamientoId;
                $relevamientoComida->ComidaId = $comidaId;
                $relevamientoComida->RelevamientoComidaCantidad = 1;
                $relevamientoComida->save();
            }
        }
        if ($resultado) {
            return response()->json(['success'=>$request->get('cama')]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function destroy($id)
    {
        $detalleRelevamiento = DetalleRelevamiento::findOrFail($id);
        $detallesRelevamientoPorComida = DetRelevamientoPorComida::where('DetalleRelevamientoId',$detalleRelevamiento->DetalleRelevamientoId)->get();
        if($detallesRelevamientoPorComida){
            foreach ($detallesRelevamientoPorComida as $detalleRelevamientoPorComida) {
                $relevamientoComida = RelevamientoComida::where('RelevamientoId',$detalleRelevamiento->RelevamientoId)
                                                        ->where('ComidaId',$detalleRelevamientoPorComida->ComidaId)
                                                        ->first();
                if($relevamientoComida){
                    $relevamientoComida = RelevamientoComida::findOrFail($relevamientoComida->RelevamientoComidaId);
                    $relevamientoComida->RelevamientoComidaCantidad = $relevamientoComida->RelevamientoComidaCantidad - 1;
                    $relevamientoComida->update();
                }
            }
        }
        $camaid = $detalleRelevamiento->CamaId;
        $resultado = $detalleRelevamiento->delete();
        if ($resultado) {
            return response()->json(['success'=>$camaid]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}




// public function store(Request $request)
//     {
//         //ESTADO DE RELEVAMIENTO A PACIENTES:
//         //DetalleRelevamientoEstado = 1 -> Activo y pertenece al último relevamient del paciente.
//         //DetalleRelevamientoEstado = 0 -> Inactivo y pertenece al penúltimo relevamiento del paciente.
//         //DetalleRelevamientoEstado = -1 -> Inactivo y pertenece a cambios de estado de pacientes(Historia del paciente).
//         $persona = Persona::where('PersonaCuil',$request->get('pacienteDNI'))->where('PersonaEstado',1)->first();
//         $paciente = Paciente::where('PersonaId',$persona->PersonaId)->first();
//         //paciente existente y cama ocupada.
//         $DRpacienteExistente = DetalleRelevamiento::where('PacienteId',$paciente->PacienteId)->where('DetalleRelevamientoEstado',1)->first();
//         $DRcamaOcupada = DetalleRelevamiento::where('CamaId',$request->get('camaId'))->where('DetalleRelevamientoEstado',1)->first();
//         $pacienteEncama = Paciente::where('PacienteId',$DRcamaOcupada->PacienteId)->where('PacienteEstado',1)->first();
//         if($request->get('pacienteExistente') == 'false' && $request->get('camaOcupada') == 'false'){
//             //el paciente está activo en algún lugar y la cama está ocupada en algún lugar.
//             if($DRpacienteExistente == $DRcamaOcupada){
//                 if($DRpacienteExistente->RelevamientoId == $request->get('relevamientoId')){
//                     //el paciente ya existe, está en la misma cama y en mismo relevamiento
//                     $DRpacienteExistente->DetalleRelevamientoEstado = -1;
//                     $paciente->PacienteEstado = 0;
//                     $paciente->update();
//                     $DRpacienteExistente->update();
//                 }else{
//                     //el paciente ya existe, está en la misma cama y en distinto relevamiento
//                     $DRpacienteExistente->DetalleRelevamientoEstado = 0;
//                     $paciente->PacienteEstado = 0;
//                     $paciente->update();
//                     $DRpacienteExistente->update();
//                 }
//             }else{
//                 if($DRpacienteExistente->RelevamientoId == $request->get('relevamientoId') || $DRcamaOcupada->RelevamientoId == $request->get('relevamientoId')){
//                     if($DRpacienteExistente->RelevamientoId == $request->get('relevamientoId')){
//                         //el paciente ya existe en el mismo relevamiento
//                         $DRpacienteExistente->DetalleRelevamientoEstado = -1;
//                         $paciente->PacienteEstado = 0;
//                         $paciente->update();
//                         $DRpacienteExistente->update();
//                     }else{
//                         //el paciente ya existe en otro relevamient
//                         $DRpacienteExistente->DetalleRelevamientoEstado = 0;
//                         $paciente->PacienteEstado = 0;
//                         $paciente->update();
//                         $DRpacienteExistente->update();
//                     }
//                     if($DRcamaOcupada->RelevamientoId == $request->get('relevamientoId')){
//                         //la cama está ocupada en el mismo relevamiento
//                         $DRcamaOcupada->DetalleRelevamientoEstado = 0;
//                         $pacienteEncama->PacienteEstado = 0;
//                         $pacienteEncama->update();
//                         $DRcamaOcupada->update();
//                     }else{
//                         //la cama está ocupada en otro relevamiento
//                         $DRcamaOcupada->DetalleRelevamientoEstado = 0;
//                         $pacienteEncama->PacienteEstado = 0;
//                         $pacienteEncama->update();
//                         $DRcamaOcupada->update();
//                     }
//                 }else{
//                     //el paciente ya existe en otro relevamiento y la cama ya está ocupada en otro relevamiento
//                     $DRpacienteExistente->DetalleRelevamientoEstado = 0;
//                     $paciente->PacienteEstado = 0;
//                     $paciente->update();
//                     $DRpacienteExistente->update();
//                     $DRcamaOcupada->DetalleRelevamientoEstado = 0;
//                     $pacienteEncama->PacienteEstado = 0;
//                     $pacienteEncama->update();
//                     $DRcamaOcupada->update();
//                 }
//             }
//         }else{
//             if($request->get('pacienteExistente') == 'false'){
//                 //el paciente ya existe en algún lugar
//                 if($DRpacienteExistente->RelevamientoId == $request->get('relevamientoId')){
//                     //el paciente ya existe y está en el mismo relevamiento
//                     $DRpacienteExistente->DetalleRelevamientoEstado = -1;
//                     $paciente->PacienteEstado = 0;
//                     $paciente->update();
//                     $DRpacienteExistente->update();
//                 }else{
//                     //el paciente ya existe y está en otro relevamiento
//                     $DRpacienteExistente->DetalleRelevamientoEstado = 0;
//                     $paciente->PacienteEstado = 0;
//                     $paciente->update();
//                     $DRpacienteExistente->update();
//                 }
//             }elseif($request->get('camaOcupada') == 'false'){
//                 if($DRcamaOcupada->RelevamientoId == $request->get('relevamientoId')){
//                     //la cama está ocupada en el mismo relevamiento
//                     $DRcamaOcupada->DetalleRelevamientoEstado = 0;
//                     $pacienteEncama->PacienteEstado = 0;
//                     $pacienteEncama->update();
//                     $DRcamaOcupada->update();
//                 }else{
//                     //la cama está ocupada en otro relevamiento
//                     $DRcamaOcupada->DetalleRelevamientoEstado = 0;
//                     $pacienteEncama->PacienteEstado = 0;
//                     $pacienteEncama->update();
//                     $DRcamaOcupada->update();
//                 }
//             }
//         }
        
//         $detalleRelevamiento = new DetalleRelevamiento;
//         $detalleRelevamiento->DetalleRelevamientoFechora = date('H:i:s');
//         $detalleRelevamiento->DetalleRelevamientoEstado = 1;
//         $paciente->PacienteEstado = 1;
//         $paciente->update();
//         $detalleRelevamiento->RelevamientoId = $request->get('relevamientoId');
//         $detalleRelevamiento->PacienteId = $paciente->PacienteId;
//         $detalleRelevamiento->CamaId = $request->get('camaId');
//         $detalleRelevamiento->TipoPacienteId = $request->get('tipoPacienteId');
//         $detalleRelevamiento->DetalleRelevamientoDiagnostico = $request->get('diagnostico');
//         $detalleRelevamiento->DetalleRelevamientoObservaciones = $request->get('observaciones');
//         $detalleRelevamiento->UserId = $request->get('usuarioId');
//         if($request->get('acompaniante') == 1){
//             $detalleRelevamiento->DetalleRelevamientoAcompaniante = $request->get('acompaniante');
//         }else{
//             $detalleRelevamiento->DetalleRelevamientoAcompaniante = 0;
//         }
//         $resultado = $detalleRelevamiento->save();
//         if ($resultado) {
//             return response()->json(['success'=>'true']);
//         }else{
//             return response()->json(['success'=>'false']);
//         }
//     }


// public function update(Request $request, $id)
//     {
//         $persona = Persona::where('PersonaCuil',$request->get('pacienteDNI'))->first();
//         $paciente = Paciente::where('PersonaId',$persona->PersonaId)->first();
//         //paciente existente y cama ocupada.
//         $DRpacienteExistente = DetalleRelevamiento::where('PacienteId',$paciente->PacienteId)->where('DetalleRelevamientoEstado',1)->first();
//         $DRcamaOcupada = DetalleRelevamiento::where('CamaId',$request->get('camaId'))->where('DetalleRelevamientoEstado',1)->first();
//         $pacienteEncama = Paciente::where('PacienteId',$DRcamaOcupada->PacienteId)->where('PacienteEstado',1)->first();
//         if($request->get('pacienteExistente') == 'false' && $request->get('camaOcupada') == 'false'){
//             //el paciente está activo en algún lugar y la cama está ocupada en algún lugar.
//             if($DRpacienteExistente == $DRcamaOcupada){
//                 if($DRpacienteExistente->RelevamientoId != $request->get('relevamientoId')){
//                     //el paciente ya existe, está en la misma cama y en distinto relevamiento
//                     $DRpacienteExistente->DetalleRelevamientoEstado = 0;
//                     $paciente->PacienteEstado = 0;
//                     $paciente->update();
//                     $DRpacienteExistente->update();
//                 }
//             }else{
//                 if($DRpacienteExistente->RelevamientoId == $request->get('relevamientoId') || $DRcamaOcupada->RelevamientoId == $request->get('relevamientoId')){
//                     if($DRpacienteExistente->RelevamientoId != $request->get('relevamientoId')){
//                         //el paciente ya existe en otro relevamient
//                         $DRpacienteExistente->DetalleRelevamientoEstado = 0;
//                         $paciente->PacienteEstado = 0;
//                         $paciente->update();
//                         $DRpacienteExistente->update();
//                     }
//                     if($DRcamaOcupada->RelevamientoId != $request->get('relevamientoId')){
//                         //la cama está ocupada en otro relevamiento
//                         $DRcamaOcupada->DetalleRelevamientoEstado = 0;
//                         $pacienteEncama->PacienteEstado = 0;
//                         $pacienteEncama->update();
//                         $DRcamaOcupada->update();
//                     }
//                 }else{
//                     //el paciente ya existe en otro relevamiento y la cama ya está ocupada en otro relevamiento
//                     $DRpacienteExistente->DetalleRelevamientoEstado = 0;
//                     $DRpacienteExistente->update();
//                     $paciente->PacienteEstado = 0;
//                     $paciente->update();
//                     $DRcamaOcupada->DetalleRelevamientoEstado = 0;
//                     $pacienteEncama->PacienteEstado = 0;
//                     $pacienteEncama->update();
//                     $DRcamaOcupada->update();
//                 }
//             }
//         }else{
//             if($request->get('pacienteExistente') == 'false'){
//                 //el paciente ya existe en algún lugar
//                 if($DRpacienteExistente->RelevamientoId != $request->get('relevamientoId')){
//                     //el paciente ya existe y está en otro relevamiento
//                     $DRpacienteExistente->DetalleRelevamientoEstado = 0;
//                     $paciente->PacienteEstado = 0;
//                     $paciente->update();
//                     $DRpacienteExistente->update();
//                 }
//             }elseif($request->get('camaOcupada') == 'false'){
//                 if($DRcamaOcupada->RelevamientoId == $request->get('relevamientoId')){
//                     //la cama está ocupada en el mismo relevamiento
//                     $DRcamaOcupada->DetalleRelevamientoEstado = 0;
//                     $pacienteEncama->PacienteEstado = 0;
//                     $pacienteEncama->update();
//                     $DRcamaOcupada->update();
//                 }else{
//                     //la cama está ocupada en otro relevamiento
//                     $DRcamaOcupada->DetalleRelevamientoEstado = 0;
//                     $pacienteEncama->PacienteEstado = 0;
//                     $pacienteEncama->update();
//                     $DRcamaOcupada->update();
//                 }
//             }
//         }
        
//         $detalleRelevamiento = DetalleRelevamiento::findOrFail($id);
//         $detalleRelevamiento->DetalleRelevamientoFechora = date('H:i:s');
//         $detalleRelevamiento->DetalleRelevamientoEstado = 1;
//         $detalleRelevamiento->RelevamientoId = $request->get('relevamientoId');
//         $detalleRelevamiento->PacienteId = $paciente->PacienteId;
//         $detalleRelevamiento->CamaId = $request->get('camaId');
//         $detalleRelevamiento->TipoPacienteId = $request->get('tipoPacienteId');
//         $detalleRelevamiento->DetalleRelevamientoDiagnostico = $request->get('diagnostico');
//         $detalleRelevamiento->DetalleRelevamientoObservaciones = $request->get('observaciones');
//         $detalleRelevamiento->UserId = $request->get('usuarioId');
//         if($request->get('acompaniante') == 1){
//             $detalleRelevamiento->DetalleRelevamientoAcompaniante = $request->get('acompaniante');
//         }else{
//             $detalleRelevamiento->DetalleRelevamientoAcompaniante = 0;
//         }
//         $resultado = $detalleRelevamiento->update();

//         if ($resultado) {
//             return response()->json(['success'=>'true']);
//         }else{
//             return response()->json(['success'=>'false']);
//         }
//     }