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
        $persona = Persona::where('PersonaCuil',$request->get('pacienteDNI'))->first();
        $paciente = Paciente::where('PersonaId',$persona->PersonaId)->first();
        //paciente existente y cama ocupada.
        $DRpacienteExistente = DetalleRelevamiento::where('PacienteId',$paciente->PacienteId)->where('DetalleRelevamientoEstado',1)->first();
        $DRcamaOcupada = DetalleRelevamiento::where('CamaId',$request->get('camaId'))->where('DetalleRelevamientoEstado',1)->first();
        if($request->get('pacienteExistente') == 'false' && $request->get('camaOcupada') == 'false'){
            //el paciente está activo en algún lugar y la cama está ocupada en algún lugar.
            if($DRpacienteExistente == $DRcamaOcupada){
                if($DRpacienteExistente->RelevamientoId == $request->get('relevamientoId')){
                    //el paciente ya existe, está en la misma cama y en mismo relevamiento
                    $DRpacienteExistente->delete();
                }else{
                    //el paciente ya existe, está en la misma cama y en distinto relevamiento
                    $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                    $DRpacienteExistente->update();
                }
            }else{
                if($DRpacienteExistente->RelevamientoId == $request->get('relevamientoId') || $DRcamaOcupada->RelevamientoId == $request->get('relevamientoId')){
                    if($DRpacienteExistente->RelevamientoId == $request->get('relevamientoId')){
                        //el paciente ya existe en el mismo relevamiento
                        $DRpacienteExistente->delete();
                    }else{
                        //el paciente ya existe en otro relevamient
                        $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                        $DRpacienteExistente->update();
                    }
                    if($DRcamaOcupada->RelevamientoId == $request->get('relevamientoId')){
                        //la cama está ocupada en el mismo relevamiento
                        $DRcamaOcupada->delete();
                    }else{
                        //la cama está ocupada en otro relevamiento
                        $DRcamaOcupada->DetalleRelevamientoEstado = 0;
                        $DRcamaOcupada->update();
                    }
                }else{
                    //el paciente ya existe en otro relevamiento y la cama ya está ocupada en otro relevamiento
                    $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                    $DRpacienteExistente->update();
                    $DRcamaOcupada->DetalleRelevamientoEstado = 0;
                    $DRcamaOcupada->update();
                }
            }
        }else{
            if($request->get('pacienteExistente') == 'false'){
                //el paciente ya existe en algún lugar
                if($DRpacienteExistente->RelevamientoId == $request->get('relevamientoId')){
                    //el paciente ya existe y está en el mismo relevamiento
                    $DRpacienteExistente->delete();
                }else{
                    //el paciente ya existe y está en otro relevamiento
                    $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                    $DRpacienteExistente->update();
                }
            }elseif($request->get('camaOcupada') == 'false'){
                if($DRcamaOcupada->RelevamientoId == $request->get('relevamientoId')){
                    //la cama está ocupada en el mismo relevamiento
                    $DRcamaOcupada->delete();
                }else{
                    //la cama está ocupada en otro relevamiento
                    $DRcamaOcupada->DetalleRelevamientoEstado = 0;
                    $DRcamaOcupada->update();
                }
            }
        }
        
        $detalleRelevamiento = new DetalleRelevamiento;
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
        $resultado = $detalleRelevamiento->save();
        if ($resultado) {
            return response()->json(['success'=>'true']);
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
        $persona = Persona::where('PersonaCuil',$request->get('pacienteDNI'))->first();
        $paciente = Paciente::where('PersonaId',$persona->PersonaId)->first();
        //paciente existente y cama ocupada.
        $DRpacienteExistente = DetalleRelevamiento::where('PacienteId',$paciente->PacienteId)->where('DetalleRelevamientoEstado',1)->first();
        $DRcamaOcupada = DetalleRelevamiento::where('CamaId',$request->get('camaId'))->where('DetalleRelevamientoEstado',1)->first();
        if($request->get('pacienteExistente') == 'false' && $request->get('camaOcupada') == 'false'){
            //el paciente está activo en algún lugar y la cama está ocupada en algún lugar.
            if($DRpacienteExistente == $DRcamaOcupada){
                if($DRpacienteExistente->RelevamientoId != $request->get('relevamientoId')){
                    //el paciente ya existe, está en la misma cama y en distinto relevamiento
                    $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                    $DRpacienteExistente->update();
                }
            }else{
                if($DRpacienteExistente->RelevamientoId == $request->get('relevamientoId') || $DRcamaOcupada->RelevamientoId == $request->get('relevamientoId')){
                    if($DRpacienteExistente->RelevamientoId != $request->get('relevamientoId')){
                        //el paciente ya existe en otro relevamient
                        $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                        $DRpacienteExistente->update();
                    }
                    if($DRcamaOcupada->RelevamientoId != $request->get('relevamientoId')){
                        //la cama está ocupada en otro relevamiento
                        $DRcamaOcupada->DetalleRelevamientoEstado = 0;
                        $DRcamaOcupada->update();
                    }
                }else{
                    //el paciente ya existe en otro relevamiento y la cama ya está ocupada en otro relevamiento
                    $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                    $DRpacienteExistente->update();
                    $DRcamaOcupada->DetalleRelevamientoEstado = 0;
                    $DRcamaOcupada->update();
                }
            }
        }else{
            if($request->get('pacienteExistente') == 'false'){
                //el paciente ya existe en algún lugar
                if($DRpacienteExistente->RelevamientoId != $request->get('relevamientoId')){
                    //el paciente ya existe y está en otro relevamiento
                    $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                    $DRpacienteExistente->update();
                }
            }elseif($request->get('camaOcupada') == 'false'){
                if($DRcamaOcupada->RelevamientoId == $request->get('relevamientoId')){
                    //la cama está ocupada en el mismo relevamiento
                    $DRcamaOcupada->delete();
                }else{
                    //la cama está ocupada en otro relevamiento
                    $DRcamaOcupada->DetalleRelevamientoEstado = 0;
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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