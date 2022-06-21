<?php

namespace App\Http\Controllers;

use App\Paciente;
use App\Relevamiento;
use App\RelevamientoComida;
use App\DetalleRelevamiento;
use Illuminate\Http\Request;
use App\DetRelevamientoPorComida;
use App\RelevamientoPorSala;
use Illuminate\Support\Facades\DB;

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

    public function store(Request $request)//request: relevamientoPorSalaId,paciente_modo_carga , paciente, paciente_nombre, paciente_apellido, paciente_dni, cama, diagnostico, observaciones, menu, tipopaciente, acompaniante, vajilladescartable, user, comidas[], colacion
    {
        $this->verificar_existencia_paciente($request->get('paciente'));
        if($request->get('paciente_modo_carga') == 'add_new'){
            $this->set_paciente_nuevo($request->get('paciente_nombre'), $request->get('paciente_apellido'), $request->get('paciente_dni'));
        }
        $para_acompaniante = 0;
        $relevamientoPorSala = RelevamientoPorSala::findOrFail($request->get('relevamientoPorSalaId'));
        if($relevamientoPorSala){
            $relevamiento = Relevamiento::findOrFail($relevamientoPorSala->RelevamientoId);
        }
        //seteo el detalle de relevamiento.
        $detalleRelevamiento = $this->setDetalleRelevamiento($request->all());
        
        $comidas = $request->get('comidas');
        
        //sumo y seteo cantidad de comidas en el relevamiento actual.
        foreach ($comidas as $comida) {
            $this->setComidaPorRelevamiento($comida,$detalleRelevamiento->DetalleRelevamientoId,$relevamientoPorSala->RelevamientoId,$para_acompaniante);
        }
        
        //acompañante
        if($detalleRelevamiento->DetalleRelevamientoAcompaniante == 1){
            $para_acompaniante = 1;
            $comidas = $this->get_comidas_por_tipo($detalleRelevamiento->MenuId,1,$request['comidas_acompaniente']);//1 = Normal
            //sumo y seteo cantidad de comidas del acompañante en el relevamiento actual.
            foreach ($comidas as $comida) {
                $this->setComidaPorRelevamiento($comida,$detalleRelevamiento->DetalleRelevamientoId,$relevamientoPorSala->RelevamientoId,$para_acompaniante);
            }
        }

        //colacion
        if($request->get('colacion') != null){
            $para_acompaniante = 0;
            $comida = ['ComidaId' => $request->get('colacion')];
            //sumo y seteo la colacion en el relevamiento actual.
            $this->setComidaPorRelevamiento($comida,$detalleRelevamiento->DetalleRelevamientoId,$relevamientoPorSala->RelevamientoId,$para_acompaniante);
        }
        if ($detalleRelevamiento) {
            return response()->json(['success'=>$request->get('cama')]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function show($id,Request $request)
    { 
        if($request->get('tipoconsulta') == 1){
            $detalleRelevamiento = 
            DB::table('detallerelevamiento as dr')
            ->join('paciente as pa','pa.PacienteId','dr.PacienteId')
            ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
            ->join('cama as c','c.CamaId','dr.CamaId')
            ->join('pieza as pi','pi.PiezaId','c.PiezaId')
            ->join('users as u','u.id','dr.UserId')
            ->join('menu as m','m.MenuId','dr.MenuId')
            ->join('relevamientoporsala as rps','rps.RelevamientoPorSalaId','dr.RelevamientoPorSalaId')
            ->where('dr.CamaId',$request->get('camaId'))
            ->where('dr.RelevamientoPorSalaId',$request->get('relevamientoPorSalaId'))
            ->select('dr.DetalleRelevamientoId',
                    DB::raw('DATE_FORMAT(dr.updated_at, "%H:%i:%s") as DetalleRelevamientoHora'),'dr.RelevamientoPorSalaId',
                    'dr.DetalleRelevamientoDiagnostico',
                    'dr.DetalleRelevamientoAcompaniante',
                    'dr.DetalleRelevamientoVajillaDescartable',
                    'dr.DetalleRelevamientoEstado','dr.DetalleRelevamientoObservaciones',
                    'dr.DetalleRelevamientoColacion',
                    'm.MenuNombre','m.MenuId',
                    'pa.PacienteId','pa.PacienteNombre','pa.PacienteApellido','pa.PacienteCuil',
                    'tp.TipoPacienteNombre','tp.TipoPacienteId',
                    'c.CamaNumero','pi.PiezaPseudonimo','c.CamaId',
                    'u.name as Relevador','u.id as UserId',
                    'rps.RelevamientoId')
            ->orderby('dr.updated_at','desc')
            ->first();
            if(!$detalleRelevamiento){
                $detalleRelevamiento = 
                DB::table('detallerelevamiento as dr')
                ->join('paciente as pa','pa.PacienteId','dr.PacienteId')
                ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                ->join('cama as c','c.CamaId','dr.CamaId')
                ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                ->join('users as u','u.id','dr.UserId')
                ->join('menu as m','m.MenuId','dr.MenuId')
                ->join('relevamientoporsala as rps','rps.RelevamientoPorSalaId','dr.RelevamientoPorSalaId')
                ->where('dr.CamaId',$request->get('camaId'))
                ->select('dr.DetalleRelevamientoId',
                        DB::raw('DATE_FORMAT(dr.updated_at, "%H:%i:%s") as DetalleRelevamientoHora'),'dr.RelevamientoPorSalaId',
                        'dr.DetalleRelevamientoDiagnostico',
                        'dr.DetalleRelevamientoAcompaniante',
                        'dr.DetalleRelevamientoVajillaDescartable',
                        'dr.DetalleRelevamientoEstado','dr.DetalleRelevamientoObservaciones',
                        'dr.DetalleRelevamientoColacion',
                        'm.MenuNombre','m.MenuId',
                        'pa.PacienteId','pa.PacienteNombre','pa.PacienteApellido','pa.PacienteCuil',
                        'tp.TipoPacienteNombre','tp.TipoPacienteId',
                        'c.CamaNumero','pi.PiezaPseudonimo','c.CamaId',
                        'u.name as Relevador','u.id as UserId',
                        'rps.RelevamientoId')
                ->orderby('dr.updated_at','desc')
                ->first();
            }
            if($detalleRelevamiento){
                return response()->json(['success'=>$detalleRelevamiento]);
            }else{
                return response()->json(['success'=>false]);
            }
        }else{
            if($request->get('paciente')){
                $paciente = Paciente::where('PacienteCuil',$request->get('paciente'))->where('PacienteEstado',1)->first();
                $detalleRelevamiento = 
                    DB::table('detallerelevamiento as dr')
                    ->join('paciente as pa','pa.PacienteId','dr.PacienteId')
                    ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                    ->join('cama as c','c.CamaId','dr.CamaId')
                    ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                    ->join('users as u','u.id','dr.UserId')
                    ->join('menu as m','m.MenuId','dr.MenuId')
                    ->where('dr.PacienteId',$paciente->PacienteId)
                    ->where('dr.DetalleRelevamientoEstado','=',1)
                    ->select('dr.DetalleRelevamientoId',
                            DB::raw('DATE_FORMAT(dr.updated_at, "%H:%i:%s") as DetalleRelevamientoHora'),'dr.RelevamientoPorSalaId',
                            'dr.DetalleRelevamientoDiagnostico',
                            'dr.DetalleRelevamientoAcompaniante',
                            'dr.DetalleRelevamientoVajillaDescartable',
                            'dr.DetalleRelevamientoEstado','dr.DetalleRelevamientoObservaciones',
                            'dr.DetalleRelevamientoColacion',
                            'm.MenuNombre','m.MenuId',
                            'pa.PacienteId','pa.PacienteNombre','pa.PacienteApellido','pa.PacienteCuil',
                            'tp.TipoPacienteNombre','tp.TipoPacienteId',
                            'c.CamaNumero','pi.PiezaPseudonimo','c.CamaId',
                            'u.name as Relevador','u.id as UserId')
                    ->orderby('dr.updated_at','desc')
                    ->first();
            }else{
                $detalleRelevamiento = 
                DB::table('detallerelevamiento as dr')
                ->join('paciente as pa','pa.PacienteId','dr.PacienteId')
                ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                ->join('cama as c','c.CamaId','dr.CamaId')
                ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                ->join('users as u','u.id','dr.UserId')
                ->join('menu as m','m.MenuId','dr.MenuId')
                ->where('dr.CamaId',$request->get('camaId'))
                ->where('dr.DetalleRelevamientoEstado','=',1)
                ->select('dr.DetalleRelevamientoId',
                        DB::raw('DATE_FORMAT(dr.updated_at, "%H:%i:%s") as DetalleRelevamientoHora'),'dr.RelevamientoPorSalaId',
                        'dr.DetalleRelevamientoDiagnostico',
                        'dr.DetalleRelevamientoAcompaniante',
                        'dr.DetalleRelevamientoVajillaDescartable',
                        'dr.DetalleRelevamientoEstado','dr.DetalleRelevamientoObservaciones',
                        'dr.DetalleRelevamientoColacion',
                        'm.MenuNombre','m.MenuId',
                        'pa.PacienteId','pa.PacienteNombre','pa.PacienteApellido','pa.PacienteCuil',
                        'tp.TipoPacienteNombre','tp.TipoPacienteId',
                        'c.CamaNumero','pi.PiezaPseudonimo','c.CamaId',
                        'u.name as Relevador','u.id as UserId')
                ->orderby('dr.updated_at','desc')
                ->first();
            }
            if($detalleRelevamiento){
                return response()->json(['success'=>$detalleRelevamiento]);
            }else{
                return response()->json(['success'=>false]);
            }
        }
    }

    public function edit($id)
    { }

    public function update(Request $request, $id)//request: relevamiento, paciente, cama, diagnostico, observaciones, menu, tipopaciente, acompaniante, vajilladescartable, user, comidas[], colacion
    {
        $this->verificar_existencia_paciente($request->get('paciente'));
        if($request->get('paciente_modo_carga') == 'add_new'){
            $this->set_paciente_nuevo($request->get('paciente_nombre'), $request->get('paciente_apellido'), $request->get('paciente_dni'));
        }
        $para_acompaniante = 0;
        $relevamientoPorSala = RelevamientoPorSala::findOrFail($request->get('relevamientoPorSalaId'));
        if($relevamientoPorSala){
            $relevamiento = Relevamiento::findOrFail($relevamientoPorSala->RelevamientoId);
        }
        //actualizo estado del relevamiento que se está queriendo editar para guardarlo como historial del paciente
        $detalleRelevamiento = DetalleRelevamiento::findOrFail($id);
        if($detalleRelevamiento->DetalleRelevamientoEstado == 1){
            $detalleRelevamiento->DetalleRelevamientoEstado = 0;
            $detalleRelevamiento->update();
        }
        //seteo el nuevo detalle de relevamiento
        $detalleRelevamiento = $this->setDetalleRelevamiento($request->all());

        //seteo un segundo más la última acualización porque uso este campo para obtener el último registro editado. (conflicto con el detalle relevamiento antiguo)
        $detalleRelevamiento = DetalleRelevamiento::findOrFail($detalleRelevamiento->DetalleRelevamientoId);
        $detalleRelevamiento->updated_at = date("m/d/Y h:i:s a", time() + 1);
        $detalleRelevamiento->update();

        $comidas = $request->get('comidas');
        //sumo y seteo cantidad de comidas en el relevamiento actual.
        foreach ($comidas as $comida) {
            $this->setComidaPorRelevamiento($comida,$detalleRelevamiento->DetalleRelevamientoId,$relevamientoPorSala->RelevamientoPorSalaId,$para_acompaniante);
        }

        //acompañante
        if($detalleRelevamiento->DetalleRelevamientoAcompaniante == 1){
            $para_acompaniante = 1;
            $comidas = $this->get_comidas_por_tipo($detalleRelevamiento->MenuId,1,$request['comidas_acompaniente']);//1 = Normal
            //sumo y seteo cantidad de comidas del acompañante en el relevamiento actual.
            foreach ($comidas as $comida) {
                $this->setComidaPorRelevamiento($comida,$detalleRelevamiento->DetalleRelevamientoId,$relevamientoPorSala->RelevamientoId,$para_acompaniante);
            }
        }

        //colacion
        if($request->get('colacion') != null){
            $para_acompaniante = 0;
            $comida = ['ComidaId' => $request->get('colacion')];
            //sumo y seteo la colacion en el relevamiento actual.
            $this->setComidaPorRelevamiento($comida,$detalleRelevamiento->DetalleRelevamientoId,$relevamientoPorSala->RelevamientoPorSalaId,$para_acompaniante);
        }
        if ($detalleRelevamiento) {
            return response()->json(['success'=>$request->get('cama')]);
        }else{
            return response()->json(['success'=>'false']);
        }
    }

    public function destroy($id)
    {
        $detalleRelevamiento = DetalleRelevamiento::findOrFail($id);
        if($detalleRelevamiento->DetalleRelevamientoEstado == 1){
            $detallesRelevamientoPorComida = DetRelevamientoPorComida::where('DetalleRelevamientoId',$detalleRelevamiento->DetalleRelevamientoId)->get();
            if($detallesRelevamientoPorComida){
                foreach ($detallesRelevamientoPorComida as $detalleRelevamientoPorComida) {
                    $detalleRelevamientoPorComida->delete();
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

    private function getComidasPorTurno($detalleMenuTipoPacienteId,$tiposComida){
        $comidas = DB::table('comidaportipopaciente as cptp')
        ->select('c.ComidaId')
        ->join('comida as c','c.ComidaId','cptp.ComidaId')
        ->join('tipocomida as tc','tc.TipoComidaId','c.TipoComidaId')
        ->whereIn('tc.TipoComidaNombre',$tiposComida)
        ->where('cptp.DetalleMenuTipoPacienteId',$detalleMenuTipoPacienteId)
        ->where('cptp.ComidaPorTipoPacientePrincipal',1)
        ->get();

        $comidas = json_decode($comidas,true);
        return $comidas;
    }

    private function setComidaPorRelevamiento($comida,$detalleRelevamientoId,$relevamientoId,$para_acompaniante){
        if($comida != null && $comida['ComidaId'] != null){
            $detRelevamientoPorComida = new DetRelevamientoPorComida;
            $detRelevamientoPorComida->DetalleRelevamientoId = $detalleRelevamientoId;
            $detRelevamientoPorComida->ComidaId = $comida['ComidaId'];
            $detRelevamientoPorComida->para_acompaniante = $para_acompaniante;
            $detRelevamientoPorComida->save();
        }
    }

    private function setDetalleRelevamiento($request){
        $detalleRelevamiento = new DetalleRelevamiento;
        $detalleRelevamiento->DetalleRelevamientoEstado = 1;
        $detalleRelevamiento->RelevamientoPorSalaId = $request['relevamientoPorSalaId'];
        
        if($request['paciente'] != null){
            $paciente = Paciente::where('PacienteCuil',$request['paciente'])->where('PacienteEstado','!=',-1)->first();
        }else{
            $paciente = Paciente::where('PacienteCuil',$request['paciente_dni'])->where('PacienteEstado','!=',-1)->first();
        }
        $detalleRelevamiento->PacienteId = $paciente->PacienteId;
        $detalleRelevamiento->CamaId = $request['cama'];
        $detalleRelevamiento->DetalleRelevamientoDiagnostico = $request['diagnostico'];
        $detalleRelevamiento->DetalleRelevamientoObservaciones = $request['observaciones'];
        $detalleRelevamiento->MenuId = $request['menu'];
        $detalleRelevamiento->TipoPacienteId = $request['tipopaciente'];
        if($request['acompaniante'] == 'true'){
            $detalleRelevamiento->DetalleRelevamientoAcompaniante = 1;
        }else{
            $detalleRelevamiento->DetalleRelevamientoAcompaniante = 0;
        }
        if($request['vajilladescartable'] == 'true'){
            $detalleRelevamiento->DetalleRelevamientoVajillaDescartable = 1;
        }else{
            $detalleRelevamiento->DetalleRelevamientoVajillaDescartable = 0;
        }
        $detalleRelevamiento->UserId = $request['user'];
        // $detalleRelevamiento->DetalleRelevamientoColacion = $request['colacion'];
        $detalleRelevamiento->save();

        return $detalleRelevamiento;
    }

    private function set_paciente_nuevo($nombre,$apellido,$dni){
        $paciente = new Paciente;
        $paciente->PacienteNombre = $nombre;
        $paciente->PacienteApellido = $apellido;
        $paciente->PacienteCuil = $dni;
        $paciente->PacienteEstado = 1;
        $paciente->save();
        sleep(1); // tiempo para que se cree el paciente correctamente
    }

    private function verificar_existencia_paciente($paciente_cuil){
        $paciente = DB::table('paciente')
                      ->where('PacienteCuil',$paciente_cuil)
                      ->where('PacienteEstado',1)
                      ->first();
        if($paciente){
            $detalle_existente = DB::table('detallerelevamiento')
                                   ->where('PacienteId',$paciente->PacienteId)
                                   ->where('DetalleRelevamientoEstado',1)
                                   ->update(['DetalleRelevamientoEstado' => 0]);
        }
    }

    private function get_comidas_por_tipo($menuId,$tipoPacienteId,$tiposComidaId){
        $tiposComida = [];
        foreach ($tiposComidaId as $tipoComidaId) {
            array_push($tiposComida,$tipoComidaId['tipoComidaId']);
        }
        $comidas_acompaniante = DB::table('comidaportipopaciente as cptp')
                ->join('detallemenutipopaciente as dmtp','dmtp.DetalleMenuTipoPacienteId','cptp.DetalleMenuTipoPacienteId')
                ->join('comida as c','c.ComidaId','cptp.ComidaId')
                ->where('dmtp.MenuId',$menuId)
                ->where('dmtp.TipoPacienteId',$tipoPacienteId)
                ->whereIn('c.TipoComidaId',$tiposComida)
                ->where('cptp.Variante',1)
                ->get();
        return json_decode($comidas_acompaniante, true);
    }

}