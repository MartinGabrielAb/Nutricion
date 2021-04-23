<?php

namespace App\Http\Controllers;

use App\Persona;
use App\Paciente;
use App\Historial;
use App\Relevamiento;
use App\DetalleRelevamiento;
use Illuminate\Http\Request;

class DetalleRelevamientoController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('America/Argentina/Salta');
    }

    public function index()
    { }

    public function create()
    { }

    public function store(Request $request)
    {
        //ESTADO DE RELEVAMIENTO A PACIENTES:
        //DetalleRelevamientoEstado = 1 -> Activo y pertenece al último relevamient del paciente.
        //DetalleRelevamientoEstado = 0 -> Inactivo y pertenece al penúltimo relevamiento del paciente.
        //DetalleRelevamientoEstado = -1 -> Inactivo y pertenece a cambios de estado de pacientes(Historia del paciente).
        $persona = Persona::where('PersonaCuil',$request->get('pacienteDNI'))->where('PersonaEstado',1)->first();
        $paciente = Paciente::where('PersonaId',$persona->PersonaId)->first();
        //paciente existente y cama ocupada.
        $DRpacienteExistente = DetalleRelevamiento::where('PacienteId',$paciente->PacienteId)->where('DetalleRelevamientoEstado',1)->first();
        $DRcamaOcupada = DetalleRelevamiento::where('CamaId',$request->get('camaId'))->where('DetalleRelevamientoEstado',1)->first();
        $pacienteEncama = Paciente::where('PacienteId',$DRcamaOcupada->PacienteId)->where('PacienteEstado',1)->first();
        if($request->get('pacienteExistente') == 'false' && $request->get('camaOcupada') == 'false'){
            //el paciente está activo en algún lugar y la cama está ocupada en algún lugar.
            if($DRpacienteExistente == $DRcamaOcupada){
                if($DRpacienteExistente->RelevamientoId == $request->get('relevamientoId')){
                    //el paciente ya existe, está en la misma cama y en mismo relevamiento
                    $DRpacienteExistente->DetalleRelevamientoEstado = -1;
                    $paciente->PacienteEstado = 0;
                    $paciente->update();
                    $DRpacienteExistente->update();
                }else{
                    //el paciente ya existe, está en la misma cama y en distinto relevamiento
                    $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                    $paciente->PacienteEstado = 0;
                    $paciente->update();
                    $DRpacienteExistente->update();
                }
            }else{
                if($DRpacienteExistente->RelevamientoId == $request->get('relevamientoId') || $DRcamaOcupada->RelevamientoId == $request->get('relevamientoId')){
                    if($DRpacienteExistente->RelevamientoId == $request->get('relevamientoId')){
                        //el paciente ya existe en el mismo relevamiento
                        $DRpacienteExistente->DetalleRelevamientoEstado = -1;
                        $paciente->PacienteEstado = 0;
                        $paciente->update();
                        $DRpacienteExistente->update();
                    }else{
                        //el paciente ya existe en otro relevamient
                        $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                        $paciente->PacienteEstado = 0;
                        $paciente->update();
                        $DRpacienteExistente->update();
                    }
                    if($DRcamaOcupada->RelevamientoId == $request->get('relevamientoId')){
                        //la cama está ocupada en el mismo relevamiento
                        $DRcamaOcupada->DetalleRelevamientoEstado = 0;
                        $pacienteEncama->PacienteEstado = 0;
                        $pacienteEncama->update();
                        $DRcamaOcupada->update();
                    }else{
                        //la cama está ocupada en otro relevamiento
                        $DRcamaOcupada->DetalleRelevamientoEstado = 0;
                        $pacienteEncama->PacienteEstado = 0;
                        $pacienteEncama->update();
                        $DRcamaOcupada->update();
                    }
                }else{
                    //el paciente ya existe en otro relevamiento y la cama ya está ocupada en otro relevamiento
                    $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                    $paciente->PacienteEstado = 0;
                    $paciente->update();
                    $DRpacienteExistente->update();
                    $DRcamaOcupada->DetalleRelevamientoEstado = 0;
                    $pacienteEncama->PacienteEstado = 0;
                    $pacienteEncama->update();
                    $DRcamaOcupada->update();
                }
            }
        }else{
            if($request->get('pacienteExistente') == 'false'){
                //el paciente ya existe en algún lugar
                if($DRpacienteExistente->RelevamientoId == $request->get('relevamientoId')){
                    //el paciente ya existe y está en el mismo relevamiento
                    $DRpacienteExistente->DetalleRelevamientoEstado = -1;
                    $paciente->PacienteEstado = 0;
                    $paciente->update();
                    $DRpacienteExistente->update();
                }else{
                    //el paciente ya existe y está en otro relevamiento
                    $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                    $paciente->PacienteEstado = 0;
                    $paciente->update();
                    $DRpacienteExistente->update();
                }
            }elseif($request->get('camaOcupada') == 'false'){
                if($DRcamaOcupada->RelevamientoId == $request->get('relevamientoId')){
                    //la cama está ocupada en el mismo relevamiento
                    $DRcamaOcupada->DetalleRelevamientoEstado = 0;
                    $pacienteEncama->PacienteEstado = 0;
                    $pacienteEncama->update();
                    $DRcamaOcupada->update();
                }else{
                    //la cama está ocupada en otro relevamiento
                    $DRcamaOcupada->DetalleRelevamientoEstado = 0;
                    $pacienteEncama->PacienteEstado = 0;
                    $pacienteEncama->update();
                    $DRcamaOcupada->update();
                }
            }
        }
        
        $detalleRelevamiento = new DetalleRelevamiento;
        $detalleRelevamiento->DetalleRelevamientoFechora = date('H:i:s');
        $detalleRelevamiento->DetalleRelevamientoEstado = 1;
        $paciente->PacienteEstado = 1;
        $paciente->update();
        $detalleRelevamiento->RelevamientoId = $request->get('relevamientoId');
        $detalleRelevamiento->PacienteId = $paciente->PacienteId;
        $detalleRelevamiento->CamaId = $request->get('camaId');
        $detalleRelevamiento->TipoPacienteId = $request->get('tipoPacienteId');
        $detalleRelevamiento->DetalleRelevamientoDiagnostico = $request->get('diagnostico');
        $detalleRelevamiento->DetalleRelevamientoObservaciones = $request->get('observaciones');
        $detalleRelevamiento->UserId = $request->get('usuarioId');
        if($request->get('acompaniante') == 1){
            $detalleRelevamiento->DetalleRelevamientoAcompaniante = $request->get('acompaniante');
        }else{
            $detalleRelevamiento->DetalleRelevamientoAcompaniante = 0;
        }
        $resultado = $detalleRelevamiento->save();
        if ($resultado) {
            return response()->json(['success'=>'true']);
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
        $persona = Persona::where('PersonaCuil',$request->get('pacienteDNI'))->first();
        $paciente = Paciente::where('PersonaId',$persona->PersonaId)->first();
        //paciente existente y cama ocupada.
        $DRpacienteExistente = DetalleRelevamiento::where('PacienteId',$paciente->PacienteId)->where('DetalleRelevamientoEstado',1)->first();
        $DRcamaOcupada = DetalleRelevamiento::where('CamaId',$request->get('camaId'))->where('DetalleRelevamientoEstado',1)->first();
        $pacienteEncama = Paciente::where('PacienteId',$DRcamaOcupada->PacienteId)->where('PacienteEstado',1)->first();
        if($request->get('pacienteExistente') == 'false' && $request->get('camaOcupada') == 'false'){
            //el paciente está activo en algún lugar y la cama está ocupada en algún lugar.
            if($DRpacienteExistente == $DRcamaOcupada){
                if($DRpacienteExistente->RelevamientoId != $request->get('relevamientoId')){
                    //el paciente ya existe, está en la misma cama y en distinto relevamiento
                    $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                    $paciente->PacienteEstado = 0;
                    $paciente->update();
                    $DRpacienteExistente->update();
                }
            }else{
                if($DRpacienteExistente->RelevamientoId == $request->get('relevamientoId') || $DRcamaOcupada->RelevamientoId == $request->get('relevamientoId')){
                    if($DRpacienteExistente->RelevamientoId != $request->get('relevamientoId')){
                        //el paciente ya existe en otro relevamient
                        $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                        $paciente->PacienteEstado = 0;
                        $paciente->update();
                        $DRpacienteExistente->update();
                    }
                    if($DRcamaOcupada->RelevamientoId != $request->get('relevamientoId')){
                        //la cama está ocupada en otro relevamiento
                        $DRcamaOcupada->DetalleRelevamientoEstado = 0;
                        $pacienteEncama->PacienteEstado = 0;
                        $pacienteEncama->update();
                        $DRcamaOcupada->update();
                    }
                }else{
                    //el paciente ya existe en otro relevamiento y la cama ya está ocupada en otro relevamiento
                    $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                    $DRpacienteExistente->update();
                    $paciente->PacienteEstado = 0;
                    $paciente->update();
                    $DRcamaOcupada->DetalleRelevamientoEstado = 0;
                    $pacienteEncama->PacienteEstado = 0;
                    $pacienteEncama->update();
                    $DRcamaOcupada->update();
                }
            }
        }else{
            if($request->get('pacienteExistente') == 'false'){
                //el paciente ya existe en algún lugar
                if($DRpacienteExistente->RelevamientoId != $request->get('relevamientoId')){
                    //el paciente ya existe y está en otro relevamiento
                    $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                    $paciente->PacienteEstado = 0;
                    $paciente->update();
                    $DRpacienteExistente->update();
                }
            }elseif($request->get('camaOcupada') == 'false'){
                if($DRcamaOcupada->RelevamientoId == $request->get('relevamientoId')){
                    //la cama está ocupada en el mismo relevamiento
                    $DRcamaOcupada->DetalleRelevamientoEstado = 0;
                    $pacienteEncama->PacienteEstado = 0;
                    $pacienteEncama->update();
                    $DRcamaOcupada->update();
                }else{
                    //la cama está ocupada en otro relevamiento
                    $DRcamaOcupada->DetalleRelevamientoEstado = 0;
                    $pacienteEncama->PacienteEstado = 0;
                    $pacienteEncama->update();
                    $DRcamaOcupada->update();
                }
            }
        }
        
        $detalleRelevamiento = DetalleRelevamiento::findOrFail($id);
        $detalleRelevamiento->DetalleRelevamientoFechora = date('H:i:s');
        $detalleRelevamiento->DetalleRelevamientoEstado = 1;
        $detalleRelevamiento->RelevamientoId = $request->get('relevamientoId');
        $detalleRelevamiento->PacienteId = $paciente->PacienteId;
        $detalleRelevamiento->CamaId = $request->get('camaId');
        $detalleRelevamiento->TipoPacienteId = $request->get('tipoPacienteId');
        $detalleRelevamiento->DetalleRelevamientoDiagnostico = $request->get('diagnostico');
        $detalleRelevamiento->DetalleRelevamientoObservaciones = $request->get('observaciones');
        $detalleRelevamiento->UserId = $request->get('usuarioId');
        if($request->get('acompaniante') == 1){
            $detalleRelevamiento->DetalleRelevamientoAcompaniante = $request->get('acompaniante');
        }else{
            $detalleRelevamiento->DetalleRelevamientoAcompaniante = 0;
        }
        $resultado = $detalleRelevamiento->update();

        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function destroy($id)
    {
        $detalleRelevamiento = DetalleRelevamiento::findOrFail($id);
        $resultado = $detalleRelevamiento->delete();
        if ($resultado) {
            return response()->json(['success'=>'true']);
        }else{
            return response()->json(['success'=>'false']);
        }
    }
}