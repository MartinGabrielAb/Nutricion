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

    public function store(Request $request)//request: relevamientoPorSalaId, paciente, cama, diagnostico, observaciones, menu, tipopaciente, acompaniante, vajilladescartable, user, comidas[], colacion
    {
        $relevamientoPorSala = RelevamientoPorSala::findOrFail($request->get('relevamientoPorSalaId'));
        if($relevamientoPorSala){
            $relevamiento = Relevamiento::findOrFail($relevamientoPorSala->RelevamientoId);
        }
        //seteo el detalle de relevamiento.
        $detalleRelevamiento = $this->setDetalleRelevamiento($request->all());
        
        //obtengo las comidas de el menu y el regímen de este paciente.
        $tipoPaciente = DB::table('tipopaciente')->where('TipoPacienteId',$request->get('tipopaciente'))->first();
        if($tipoPaciente->TipoPacienteNombre != 'Individual'){
            $comidas = $this->get_comidas_por_menu_paciente($detalleRelevamiento->MenuId,$tipoPaciente->TipoPacienteId,$relevamiento->RelevamientoTurno);
        }else{
            //si es Individual uso las comidas seleccionadas en el crud.
            $comidas = $request->get('comidas');
        }

        //sumo y seteo cantidad de comidas en el relevamiento actual.
        foreach ($comidas as $comida) {
            $this->sumCantidadComidasPorRelevamiento($comida,$detalleRelevamiento->DetalleRelevamientoId,$relevamientoPorSala->RelevamientoId);
        }
        
        //acompañante
        if($detalleRelevamiento->DetalleRelevamientoAcompaniante == 1){
            $tipoPacienteNormal = DB::table('tipopaciente')->where('TipoPacienteNombre','Normal')->first();
            $comidas = $this->get_comidas_por_menu_paciente($detalleRelevamiento->MenuId,$tipoPacienteNormal->TipoPacienteId,$relevamiento->RelevamientoTurno);
            //sumo y seteo cantidad de comidas del acompañante en el relevamiento actual.
            foreach ($comidas as $comida) {
                $this->sumCantidadComidasPorRelevamiento($comida,$detalleRelevamiento->DetalleRelevamientoId,$relevamientoPorSala->RelevamientoId);
            }
        }

        //colacion
        if($request->get('colacion') != null){
            $comida = ['ComidaId' => $request->get('colacion')];
            //sumo y seteo la colacion en el relevamiento actual.
            $this->sumCantidadComidasPorRelevamiento($comida,$detalleRelevamiento->DetalleRelevamientoId,$relevamientoPorSala->RelevamientoId);
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
            ->where('dr.DetalleRelevamientoEstado','=',1)
            ->select('dr.DetalleRelevamientoId',
                    DB::raw('DATE_FORMAT(dr.updated_at, "%H:%i:%s") as DetalleRelevamientoHora'),'dr.RelevamientoPorSalaId',
                    'dr.DetalleRelevamientoDiagnostico',
                    'dr.DetalleRelevamientoAcompaniante',
                    'dr.DetalleRelevamientoVajillaDescartable',
                    'dr.DetalleRelevamientoAgregado',
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
                ->where('dr.DetalleRelevamientoEstado','=',1)
                ->select('dr.DetalleRelevamientoId',
                        DB::raw('DATE_FORMAT(dr.updated_at, "%H:%i:%s") as DetalleRelevamientoHora'),'dr.RelevamientoPorSalaId',
                        'dr.DetalleRelevamientoDiagnostico',
                        'dr.DetalleRelevamientoAcompaniante',
                        'dr.DetalleRelevamientoVajillaDescartable',
                        'dr.DetalleRelevamientoAgregado',
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
                            'dr.DetalleRelevamientoAgregado',
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
                        'dr.DetalleRelevamientoAgregado',
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
        // dd($id);
        $relevamientoPorSala = RelevamientoPorSala::findOrFail($request->get('relevamientoPorSalaId'));
        if($relevamientoPorSala){
            $relevamiento = Relevamiento::findOrFail($relevamientoPorSala->RelevamientoId);
        }
        //actualizo estado del relevamiento que se está queriendo editar para guardarlo como historial del paciente
        $detalleRelevamiento = DetalleRelevamiento::findOrFail($id);
        if($detalleRelevamiento->DetalleRelevamientoEstado == 1){
            $detalleRelevamiento->DetalleRelevamientoEstado = 0;
            $detallesRelevamientoPorComida = DetRelevamientoPorComida::where('DetalleRelevamientoId',$detalleRelevamiento->DetalleRelevamientoId)->get();
            if($detallesRelevamientoPorComida){
                foreach ($detallesRelevamientoPorComida as $detalleRelevamientoPorComida) {
                    $this->restarCantidadComidasPorRelevamiento($detalleRelevamientoPorComida,$relevamientoPorSala->RelevamientoPorSalaId);
                }
            }
            $detalleRelevamiento->update();
        }
        //seteo el nuevo detalle de relevamiento
        $detalleRelevamiento = $this->setDetalleRelevamiento($request->all());

        //seteo un segundo más la última acualización porque uso este campo para obtener el último registro editado. (conflicto con el detalle relevamiento antiguo)
        $detalleRelevamiento = DetalleRelevamiento::findOrFail($detalleRelevamiento->DetalleRelevamientoId);
        $detalleRelevamiento->updated_at = date("m/d/Y h:i:s a", time() + 1);
        $detalleRelevamiento->update();

        //obtengo las comidas de el menu y el regímen de este paciente.
        $tipoPaciente = DB::table('tipopaciente')->where('TipoPacienteId',$request->get('tipopaciente'))->first();
        if($tipoPaciente->TipoPacienteNombre != 'Individual'){
            $comidas = $this->get_comidas_por_menu_paciente($detalleRelevamiento->MenuId,$tipoPaciente->TipoPacienteId,$relevamiento->RelevamientoTurno);
        }else{
            //si es Individual uso las comidas seleccionadas en el crud.
            $comidas = $request->get('comidas');
        }

        //sumo y seteo cantidad de comidas en el relevamiento actual.
        foreach ($comidas as $comida) {
            $this->sumCantidadComidasPorRelevamiento($comida,$detalleRelevamiento->DetalleRelevamientoId,$relevamientoPorSala->RelevamientoPorSalaId);
        }

        //acompañante
        if($detalleRelevamiento->DetalleRelevamientoAcompaniante == 1){
            $tipoPacienteNormal = DB::table('tipopaciente')->where('TipoPacienteNombre','Normal')->first();
            $comidas = $this->get_comidas_por_menu_paciente($detalleRelevamiento->MenuId,$tipoPacienteNormal->TipoPacienteId,$relevamiento->RelevamientoTurno);
            //sumo y seteo cantidad de comidas del acompañante en el relevamiento actual.
            foreach ($comidas as $comida) {
                $this->sumCantidadComidasPorRelevamiento($comida,$detalleRelevamiento->DetalleRelevamientoId,$relevamientoPorSala->RelevamientoPorSalaId);
            }
        }

        //colacion
        if($request->get('colacion') != null){
            $comida = ['ComidaId' => $request->get('colacion')];
            //sumo y seteo la colacion en el relevamiento actual.
            $this->sumCantidadComidasPorRelevamiento($comida,$detalleRelevamiento->DetalleRelevamientoId,$relevamientoPorSala->RelevamientoPorSalaId);
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
            $relevamientoPorSala = RelevamientoPorSala::findOrFail($detalleRelevamiento->RelevamientoPorSalaId);
            if($relevamientoPorSala){
                $relevamiento = Relevamiento::findOrFail($relevamientoPorSala->RelevamientoId);
            }
            $detallesRelevamientoPorComida = DetRelevamientoPorComida::where('DetalleRelevamientoId',$detalleRelevamiento->DetalleRelevamientoId)->get();
            if($detallesRelevamientoPorComida){
                foreach ($detallesRelevamientoPorComida as $detalleRelevamientoPorComida) {
                    $this->restarCantidadComidasPorRelevamiento($detalleRelevamientoPorComida,$relevamientoPorSala->RelevamientoPorSalaId);
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

    private function sumCantidadComidasPorRelevamiento($comida,$detalleRelevamientoId,$relevamientoId){
        if($comida != null){
            $detRelevamientoPorComida = new DetRelevamientoPorComida;
            $detRelevamientoPorComida->DetalleRelevamientoId = $detalleRelevamientoId;
            $detRelevamientoPorComida->ComidaId = $comida['ComidaId'];
            $detRelevamientoPorComida->save();

            $relevamientoComida = RelevamientoComida::where('RelevamientoPorSalaId',$relevamientoId)
                                                    ->where('ComidaId',$comida['ComidaId'])
                                                    ->first();
            if($relevamientoComida){
                $relevamientoComida = RelevamientoComida::findOrFail($relevamientoComida->RelevamientoComidaId);
                $relevamientoComida->RelevamientoComidaCantidad = $relevamientoComida->RelevamientoComidaCantidad + 1;
                $relevamientoComida->update();
            }else{
                
                $relevamientoComida = new RelevamientoComida;
                $relevamientoComida->RelevamientoPorSalaId = $relevamientoId;
                $relevamientoComida->ComidaId = $comida['ComidaId'];
                $relevamientoComida->RelevamientoComidaCantidad = 1;
                $relevamientoComida->save();
            }
        }
    }

    private function restarCantidadComidasPorRelevamiento($comida,$relevamientoId){
        $relevamientoComida = RelevamientoComida::where('RelevamientoPorSalaId',$relevamientoId)
                                                ->where('ComidaId',$comida->ComidaId)
                                                ->first();
        if($relevamientoComida){
            $relevamientoComida = RelevamientoComida::findOrFail($relevamientoComida->RelevamientoComidaId);
            $relevamientoComida->RelevamientoComidaCantidad = $relevamientoComida->RelevamientoComidaCantidad - 1;
            $relevamientoComida->update();
        }
    }

    private function setDetalleRelevamiento($request){
        $detalleRelevamiento = new DetalleRelevamiento;
        $detalleRelevamiento->DetalleRelevamientoEstado = 1;
        $detalleRelevamiento->RelevamientoPorSalaId = $request['relevamientoPorSalaId'];
        $paciente = Paciente::where('PacienteCuil',$request['paciente'])->where('PacienteEstado','!=',-1)->first();
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
        if($request['agregado'] == 'true'){
            $detalleRelevamiento->DetalleRelevamientoAgregado = 1;
        }else{
            $detalleRelevamiento->DetalleRelevamientoAgregado = 0;
        }
        $detalleRelevamiento->UserId = $request['user'];
        $detalleRelevamiento->DetalleRelevamientoColacion = $request['colacion'];
        $detalleRelevamiento->save();

        return $detalleRelevamiento;
    }

    private function get_comidas_por_menu_paciente($menu_id,$tipo_paciente_id,$turno){

        $menuPorTipoPaciente = 
            DB::table('detallemenutipopaciente')
            ->where('MenuId',$menu_id)
            ->where('TipoPacienteId',$tipo_paciente_id)
            ->first();
        if($turno == 'Mañana'){
            $comidas = $this->getComidasPorTurno($menuPorTipoPaciente->DetalleMenuTipoPacienteId,['Merienda','Cena','Postre Cena','Sopa Cena']);
        }else{
            $comidas = $this->getComidasPorTurno($menuPorTipoPaciente->DetalleMenuTipoPacienteId,['Desayuno','Almuerzo','Postre Almuerzo','Sopa Almuerzo']);
        }
        
        return $comidas;
    }
}