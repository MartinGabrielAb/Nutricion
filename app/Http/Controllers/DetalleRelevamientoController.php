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
        date_default_timezone_set('America/Argentina/Salta');
        $persona = Persona::where('PersonaCuil',$request->get('pacienteDNI'))->first();
        $paciente = Paciente::where('PersonaId',$persona->PersonaId)->first();
        
        if($request->get('pacienteExistente') == 'false' && $request->get('camaOcupada') == 'false'){
            
            $DRpacienteExistente = DetalleRelevamiento::where('PacienteId',$paciente->PacienteId)->where('DetalleRelevamientoEstado',1)->first();
            $DRcamaOcupada = DetalleRelevamiento::where('CamaId',$request->get('camaId'))->where('DetalleRelevamientoEstado',1)->first();
            if($DRpacienteExistente == $DRcamaOcupada){
                $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                $DRpacienteExistente->update();
            }else{
                $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                $DRpacienteExistente->update();
                $DRcamaOcupada->DetalleRelevamientoEstado = 0;
                $DRcamaOcupada->update();
            }
        }else{
            if($request->get('pacienteExistente') == 'false'){
                $DRpacienteExistente = DetalleRelevamiento::where('PacienteId',$paciente->PacienteId)->where('DetalleRelevamientoEstado',1)->first();
                $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                $DRpacienteExistente->update();
            }else{
                if($request->get('camaOcupada') == 'false'){
                    $DRcamaOcupada = DetalleRelevamiento::where('CamaId',$request->get('camaId'))->where('DetalleRelevamientoEstado',1)->first();
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
        date_default_timezone_set('America/Argentina/Salta');
        $persona = Persona::where('PersonaCuil',$request->get('pacienteDNI'))->first();
        $paciente = Paciente::where('PersonaId',$persona->PersonaId)->first();
        
        if($request->get('pacienteExistente') == 'false' && $request->get('camaOcupada') == 'false'){
            
            $DRpacienteExistente = DetalleRelevamiento::where('PacienteId',$paciente->PacienteId)->where('DetalleRelevamientoEstado',1)->first();
            $DRcamaOcupada = DetalleRelevamiento::where('CamaId',$request->get('camaId'))->where('DetalleRelevamientoEstado',1)->first();
            if($DRpacienteExistente == $DRcamaOcupada){
                $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                $DRpacienteExistente->update();
            }else{
                $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                $DRpacienteExistente->update();
                $DRcamaOcupada->DetalleRelevamientoEstado = 0;
                $DRcamaOcupada->update();
            }
        }else{
            if($request->get('pacienteExistente') == 'false'){
                $DRpacienteExistente = DetalleRelevamiento::where('PacienteId',$paciente->PacienteId)->where('DetalleRelevamientoEstado',1)->first();
                $DRpacienteExistente->DetalleRelevamientoEstado = 0;
                $DRpacienteExistente->update();
            }else{
                if($request->get('camaOcupada') == 'false'){
                    $DRcamaOcupada = DetalleRelevamiento::where('CamaId',$request->get('camaId'))->where('DetalleRelevamientoEstado',1)->first();
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