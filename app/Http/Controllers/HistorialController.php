<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Comida;
use App\Alimento;
use App\Historial;
use App\TipoComida;
use App\Relevamiento;
use App\TipoPaciente;
use App\UnidadMedida;
use App\AlimentoPorComida;
use App\DetalleRelevamiento;
use Illuminate\Http\Request;
use App\ComidaPorTipoPaciente;
use App\HistorialTipoPaciente;
use App\DetalleMenuTipoPaciente;
use Illuminate\Support\Facades\DB;
use App\HistorialAlimentoPorComida;
use App\HistorialComidaPorTipoPaciente;
class HistorialController extends Controller
{

    public function index(Request $request)
    {
        if($request->ajax()){
            # Ejecuta si la petición es a través de AJAX.
            $historial = Historial::where('HistorialEstado',1)->get();
            if($historial){
                return datatables()->of($historial)
                                    ->addColumn('btn','historial/actions')
                                    ->rawColumns(['btn'])
                                    ->toJson();
            }
        }
        # Ejecuta si la petición NO es a través de AJAX.
        return view('historial.principal');
    }

    public function create($id)
    {

        return view('historial.create');
    }

    public function elegirMenu($id)
    {
        $relevamiento = Relevamiento::findOrFail($id);
        $detallesGenerales = DB::table('detallerelevamiento as dr')
                                    ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                                    ->where('dr.RelevamientoId','=',$relevamiento->RelevamientoId)
                                    ->where('TipoPacienteNombre','!=','Particular')
                                    ->where('DetalleRelevamientoEstado','=',1)
                                    ->get();

        $detallesParticulares = DB::table('detallerelevamiento as dr')
                                    ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                                    ->join('paciente as p','p.PacienteId','dr.PacienteId')
                                    ->join('persona as per','per.PersonaId','p.PersonaId')
                                    ->where('dr.RelevamientoId','=',$relevamiento->RelevamientoId)
                                    ->where('TipoPacienteNombre','=','Particular')
                                    ->where('DetalleRelevamientoEstado','=',1)
                                    ->get();
        $menuesGenerales = DB::table('menu')
                                ->where('MenuEstado',1)
                                ->where('menuParticular',0)
                                ->get();
        $menuesParticulares = DB::table('menu')                            
                                ->where('MenuEstado',1)
                                ->where('menuParticular',1)
                                ->get();

        return view('historial.create',compact('relevamiento','detallesParticulares','detallesGenerales','menuesGenerales','menuesParticulares'));
    }

    public function store(Request $request)
    {
        // se puede llamar a este método desde un relevamiento ya sea por la mañana o por la tarde.
        $datos = $request->All();
        $relevamiento = Relevamiento::findOrFail($datos['relevamientoId']);
        if($relevamiento){
            $turno = $relevamiento->RelevamientoTurno;
            $fecha = $relevamiento->RelevamientoFecha;
            
            $detallesRelevamiento = DetalleRelevamiento::where('RelevamientoId',$relevamiento->RelevamientoId)->where('DetalleRelevamientoEstado',1)->get();
            $contadorAcompaniantes = 0;
            foreach ($detallesRelevamiento as $detalleRelevamiento) {
                if($detalleRelevamiento->DetalleRelevamientoAcompaniante == 1){
                    $contadorAcompaniantes += 1;
                }
            }
            // hasta el momento tenemos el relevamiento con su fecha y turno; tenemos menu general elegido y particulares elegidos.
            $menuGeneralId = $datos['menuGeneralId'];
            $menuGeneral = Menu::findOrFail($menuGeneralId);
            $historial = Historial::where('HistorialEstado',1)->where('HistorialFecha',$fecha)->where('HistorialTurno',$turno)->get();
            if(count($historial)>0){
                return response()->json(['success'=>'false','message'=>'Los menus para el relevamiento seleccionado ya fueron elegidos.']);
            }
            if ($turno == 'Mañana') {
                //Busco los menues por tipos de pacientes
                $detallesMenuTipoPaciente = DetalleMenuTipoPaciente::where('MenuId',$menuGeneral->MenuId)->get();
                if(count($detallesMenuTipoPaciente)>0){
                    //Creo la cabecera del historial y lo guardo
                    $historial = new Historial();
                    $historial->HistorialFecha = $fecha;
                    $historial->MenuNombre = $menuGeneral->MenuNombre; //ESTE CAMPO TENES QUE AGREGARLO EN LA BD.. LO TENES QUE SACAR DE LA TABLA HistorialTipoPaciente y ponerlo en la tabla Historial
                    $historial->HistorialCostoTotal = 0;
                    $historial->HistorialCantidadPacientes = 0;
                    $historial->HistorialTurno = 'Mañana';
                    $historial->HistorialEstado = 1 ;
                    $historial->save();
                    foreach ($detallesMenuTipoPaciente as $detalleMenuTipoPaciente){
                        //Solo aplica para los que no son particulares
                        $tipoPaciente = TipoPaciente::findOrFail($detalleMenuTipoPaciente->TipoPacienteId);
                        if($tipoPaciente->TipoPacienteNombre != 'Particular'){
                            
                            $historialTipoPaciente = new HistorialTipoPaciente();
                            $historialTipoPaciente->HistorialId = $historial->HistorialId;
                            $historialTipoPaciente->HistorialTipoPacienteCostoTotal = 0;
                            $historialTipoPaciente->TipoPacienteNombre = $tipoPaciente->TipoPacienteNombre;
                            $pacientesPorTipo = DetalleRelevamiento::where('RelevamientoId',$relevamiento->RelevamientoId)
                                                            ->where('TipoPacienteId',$tipoPaciente->TipoPacienteId)
                                                            ->where('DetalleRelevamientoEstado',1)
                                                            ->get();
                            if($tipoPaciente->TipoPacienteNombre == 'Normal'){
                                $historialTipoPaciente->HistorialTipoPacienteCantidad = count($pacientesPorTipo) + $contadorAcompaniantes;
                            }else{
                                $historialTipoPaciente->HistorialTipoPacienteCantidad = count($pacientesPorTipo);
                            }
                            $historialTipoPaciente->save();
                            
                            //Busco las comidas (solo almuerzo - sopa - postre y merienda)
                            $comidasPorTipoPaciente = ComidaPorTipoPaciente::where('DetalleMenuTipoPacienteId',$detalleMenuTipoPaciente->DetalleMenuTipoPacienteId)->get();
                            
                            foreach ($comidasPorTipoPaciente as $comidaPorTipoPaciente) {
                                $tipoComida = TipoComida::findOrFail($comidaPorTipoPaciente->TipoComidaId);
                                $tipoComidaNombre = $tipoComida->TipoComidaNombre;
                                $comida = Comida::findOrFail($comidaPorTipoPaciente->ComidaId);
                                $comidaNombre = $comida->ComidaNombre;
                                if($tipoComidaNombre == 'Almuerzo' or $tipoComidaNombre == 'Sopa Almuerzo' or $tipoComidaNombre == 'Postre Almuerzo' or $tipoComidaNombre == 'Merienda'){
                                    $historialComidaPorTipoPaciente = new HistorialComidaPorTipoPaciente();
                                    $historialComidaPorTipoPaciente->HistorialComidaPorTipoPacienteEstado = 1;

                                    $historialComidaPorTipoPaciente->HistorialTipoPacienteId = $historialTipoPaciente->HistorialTipoPacienteId;
                                    $historialComidaPorTipoPaciente->ComidaNombre = $comidaNombre;
                                    $historialComidaPorTipoPaciente->TipoComidaNombre = $tipoComidaNombre;
                                    $historialComidaPorTipoPaciente->ComidaCostoTotal = 0;
                                    $historialComidaPorTipoPaciente->save();
                                    //Busco los alimentos que componen esa comida
                                    $alimentosPorComida = AlimentoPorComida::where('ComidaId',$comidaPorTipoPaciente->ComidaId)->get();
                                    foreach ($alimentosPorComida as $alimentoPorComida) {
                                        $historialAlimentoPorComida = new HistorialAlimentoPorComida();
                                        $historialAlimentoPorComida->HistorialAlimentoPorComidaEstado = 1; 
                                        
                                        $historialAlimentoPorComida->HistorialComidaPorTipoPacienteId = $historialComidaPorTipoPaciente->HistorialComidaPorTipoPacienteId;
                                        $alimento = Alimento::findOrFail($alimentoPorComida->AlimentoId);
                                        $unidadMedida = UnidadMedida::findOrFail($alimentoPorComida->UnidadMedidaId);
                                        $historialAlimentoPorComida->AlimentoNombre = $alimento->AlimentoNombre;
                                        $historialAlimentoPorComida->AlimentoCantidad = $alimentoPorComida->AlimentoPorComidaCantidadNeto;
                                        $historialAlimentoPorComida->AlimentoUnidadMedida = $unidadMedida->UnidadMedidaNombre;
                                        //CAMBIA EN LA BD : en la tabla historialalimentoporcomida el campo AlimentoCosto a AlimentoCostoTotal
                                        $historialAlimentoPorComida->AlimentoCostoTotal = round($alimentoPorComida->AlimentoPorComidaCostoTotal, 2);
                                        $historialAlimentoPorComida->save();
                                        //Acumulo los costos totales de los campos padres
                                        $historialComidaPorTipoPaciente->ComidaCostoTotal += round($historialAlimentoPorComida->AlimentoCostoTotal, 2);
                                    }
                                    $historialComidaPorTipoPaciente->update();
                                    $historialTipoPaciente->HistorialTipoPacienteCostoTotal += round($historialComidaPorTipoPaciente->ComidaCostoTotal, 2);
                                }
                            }
                            $historialTipoPaciente->Update();
                            $historial->HistorialCantidadPacientes += $historialTipoPaciente->HistorialTipoPacienteCantidad;
                            $historial->HistorialCostoTotal += round($historialTipoPaciente->HistorialTipoPacienteCostoTotal, 2) * round($historialTipoPaciente->HistorialTipoPacienteCantidad, 2);   
                        }
                    }
                    $resultado =  $historial->Update();
                }else{
                    //implementar un mecanismo de mensajes de respuestas posibles para el usuario.
                    //si sale por aquí quiere decir que no existen menus por tipo de paciente, por lo tanto no tiene sentido crear un historial vacío.
                    return response()->json(['success'=>'false','message'=>'No existen menus por tipo de paciente. Se deben crear menus por tipo de paciente.']);
                }    
            }else{
                //si es por la tarde selecciono el menú general escogido por la mañana y lo guardo en un nuevo historial. Por la tarde esta prohibido escoger menu general.
                $historialMañana = Historial::where('HistorialEstado',1)->where('HistorialFecha',$fecha)->where('HistorialTurno','Mañana')->first();
                if($historialMañana){
                    $detallesMenuTipoPaciente = DetalleMenuTipoPaciente::where('MenuId',$menuGeneral->MenuId)->get();
                    if(count($detallesMenuTipoPaciente)>0){
                        $historial = new Historial();
                        $historial->HistorialFecha = $fecha;
                        $historial->MenuNombre = $historialMañana->MenuNombre;
                        $historial->HistorialCostoTotal = 0;
                        $historial->HistorialCantidadPacientes = 0;
                        $historial->HistorialTurno = 'Tarde';
                        $historial->HistorialEstado = 1;
                        $historial->save();
                        
                        foreach ($detallesMenuTipoPaciente as $detalleMenuTipoPaciente){
                            //Solo aplica para los que no son particulares
                            $tipoPaciente = TipoPaciente::findOrFail($detalleMenuTipoPaciente->TipoPacienteId);
                            if($tipoPaciente->TipoPacienteNombre != 'Particular'){
                                $historialTipoPaciente = new HistorialTipoPaciente();
                                $historialTipoPaciente->HistorialId = $historial->HistorialId;
                                $historialTipoPaciente->HistorialTipoPacienteCostoTotal = 0;
                                $historialTipoPaciente->TipoPacienteNombre = $tipoPaciente->TipoPacienteNombre;
                                $pacientesPorTipo = DetalleRelevamiento::where('RelevamientoId',$relevamiento->RelevamientoId)
                                                                ->where('TipoPacienteId',$tipoPaciente->TipoPacienteId)
                                                                ->where('DetalleRelevamientoEstado',1)
                                                                ->get();
                                
                                if($tipoPaciente->TipoPacienteNombre == 'Normal'){
                                    $historialTipoPaciente->HistorialTipoPacienteCantidad = count($pacientesPorTipo) + $contadorAcompaniantes;
                                }else{
                                    $historialTipoPaciente->HistorialTipoPacienteCantidad = count($pacientesPorTipo);
                                }
                                $historialTipoPaciente->save();
                                //Busco las comidas (solo cena - sopa - postre y desayuno)
                                $comidasPorTipoPaciente = ComidaPorTipoPaciente::where('DetalleMenuTipoPacienteId',$detalleMenuTipoPaciente->DetalleMenuTipoPacienteId)->get();
                                foreach ($comidasPorTipoPaciente as $comidaPorTipoPaciente) {
                                    $tipoComida = TipoComida::findOrFail($comidaPorTipoPaciente->TipoComidaId);
                                    $tipoComidaNombre = $tipoComida->TipoComidaNombre;
                                    $comida = Comida::findOrFail($comidaPorTipoPaciente->ComidaId);
                                    $comidaNombre = $comida->ComidaNombre;
                                    if($tipoComidaNombre == 'Cena' or $tipoComidaNombre == 'Sopa Cena' or $tipoComidaNombre == 'Postre Cena' or $tipoComidaNombre == 'Desayuno'){
                                        $historialComidaPorTipoPaciente = new HistorialComidaPorTipoPaciente();
                                        $historialComidaPorTipoPaciente->HistorialComidaPorTipoPacienteEstado = 1;

                                        $historialComidaPorTipoPaciente->HistorialTipoPacienteId = $historialTipoPaciente->HistorialTipoPacienteId; 
                                        $historialComidaPorTipoPaciente->ComidaNombre = $comidaNombre;
                                        $historialComidaPorTipoPaciente->TipoComidaNombre = $tipoComidaNombre;
                                        $historialComidaPorTipoPaciente->ComidaCostoTotal = 0;
                                        $historialComidaPorTipoPaciente->save();
                                        //Busco los alimentos que componen esa comida
                                        $alimentosPorComida = AlimentoPorComida::where('ComidaId',$comidaPorTipoPaciente->ComidaId)->get();
                                        foreach ($alimentosPorComida as $alimentoPorComida) {
                                            $historialAlimentoPorComida = new HistorialAlimentoPorComida();
                                            $historialAlimentoPorComida->HistorialAlimentoPorComidaEstado = 1;

                                            $historialAlimentoPorComida->HistorialComidaPorTipoPacienteId = $historialComidaPorTipoPaciente->HistorialComidaPorTipoPacienteId;
                                            $alimento = Alimento::findOrFail($alimentoPorComida->AlimentoId);
                                            $unidadMedida = UnidadMedida::findOrFail($alimentoPorComida->UnidadMedidaId);
                                            $historialAlimentoPorComida->AlimentoNombre = $alimento->AlimentoNombre;
                                            $historialAlimentoPorComida->AlimentoCantidad = $alimentoPorComida->AlimentoPorComidaCantidadNeto;
                                            $historialAlimentoPorComida->AlimentoUnidadMedida = $unidadMedida->UnidadMedidaNombre;
                                            //CAMBIA EN LA BD : en la tabla historialalimentoporcomida el campo AlimentoCosto a AlimentoCostoTotal
                                            $historialAlimentoPorComida->AlimentoCostoTotal = round($alimentoPorComida->AlimentoPorComidaCostoTotal, 2);
                                            $historialAlimentoPorComida->save();
                                            //Acumulo los costos totales de los campos padres
                                            $historialComidaPorTipoPaciente->ComidaCostoTotal += round($historialAlimentoPorComida->AlimentoCostoTotal, 2);
                                        }
                                        $historialComidaPorTipoPaciente->update();
                                        $historialTipoPaciente->HistorialTipoPacienteCostoTotal += round($historialComidaPorTipoPaciente->ComidaCostoTotal, 2);
                                    }
                                }
                                $historialTipoPaciente->Update();
                                $historial->HistorialCantidadPacientes += $historialTipoPaciente->HistorialTipoPacienteCantidad;
                                $historial->HistorialCostoTotal += round($historialTipoPaciente->HistorialTipoPacienteCostoTotal, 2) * round($historialTipoPaciente->HistorialTipoPacienteCantidad, 2);   
                            }
                        }
                        $resultado =  $historial->Update();
                    }else{
                        //implementar un mecanismo de mensajes de respuestas posibles para el usuario.
                        //si sale por aquí quiere decir que no existen menus por tipo de paciente, por lo tanto no tiene sentido crear un historial vacío.
                        return response()->json(['success'=>'false','message'=>'No existen menus por tipo de paciente. Se deben crear menus por tipo de paciente.']);  
                    }
                }else{
                    //implementar un mecanismo de mensajes de respuestas posibles para el usuario.
                    //no existe registro del historial por la mañana. Se debe seleccionar el menú general únicamente por la mañana.
                    return response()->json(['success'=>'false','message'=>'No existe registro del historial por la mañana. Se debe seleccionar el menú general únicamente por la mañana.']);  
                }
            }
            // registrar menus particulares
            $particulares = $datos['particulares'];
            if($particulares != null){
                foreach ($particulares as $particular){
                    $menuParticularId = $particular['menuParticularId'];
                    $menuParticular = Menu::findOrFail($menuParticularId);
                    $pacienteId = $particular['pacienteId'];
                    if ($turno == 'Mañana') {
                        $historial = Historial::where('HistorialEstado',1)->where('HistorialFecha',$fecha)->where('HistorialTurno','Mañana')->first();
                        $historial->HistorialCantidadPacientes+=1;
                        $historialTipoPaciente = new HistorialTipoPaciente();
                        $historialTipoPaciente->HistorialId = $historial->HistorialId;
                        $historialTipoPaciente->HistorialTipoPacienteCantidad = 1; // VERIFICAR ESTO!
                        $historialTipoPaciente->HistorialTipoPacienteCostoTotal = 0;
                        $historialTipoPaciente->TipoPacienteNombre = 'Particular';
                        $historialTipoPaciente->PacienteId = $pacienteId;
                        $historialTipoPaciente->save();
                        $detalleMenuTipoPaciente = DetalleMenuTipoPaciente::where('MenuId',$menuParticular->MenuId)->first();
                        //Busco las comidas (solo cena - sopa - postre y desayuno)
                        $comidasPorTipoPaciente = ComidaPorTipoPaciente::where('DetalleMenuTipoPacienteId',$detalleMenuTipoPaciente->DetalleMenuTipoPacienteId)->get();
                        foreach ($comidasPorTipoPaciente as $comidaPorTipoPaciente) {
                            $tipoComida = TipoComida::findOrFail($comidaPorTipoPaciente->TipoComidaId);
                            $tipoComidaNombre = $tipoComida->TipoComidaNombre;
                            $comida = Comida::findOrFail($comidaPorTipoPaciente->ComidaId);
                            $comidaNombre = $comida->ComidaNombre;
                            if($tipoComidaNombre == 'Almuerzo' or $tipoComidaNombre == 'Sopa Almuerzo' or $tipoComidaNombre == 'Postre Almuerzo' or $tipoComidaNombre == 'Merienda'){
                                $historialComidaPorTipoPaciente = new HistorialComidaPorTipoPaciente();
                                $historialComidaPorTipoPaciente->HistorialComidaPorTipoPacienteEstado = 1;

                                $historialComidaPorTipoPaciente->HistorialTipoPacienteId = $historialTipoPaciente->HistorialTipoPacienteId; 
                                $historialComidaPorTipoPaciente->ComidaNombre = $comidaNombre;
                                $historialComidaPorTipoPaciente->TipoComidaNombre = $tipoComidaNombre;
                                $historialComidaPorTipoPaciente->ComidaCostoTotal = 0;
                                $historialComidaPorTipoPaciente->save();
                                //Busco los alimentos que componen esa comida
                                $alimentosPorComida = AlimentoPorComida::where('ComidaId',$comidaPorTipoPaciente->ComidaId)->get();
                                foreach ($alimentosPorComida as $alimentoPorComida) {
                                    $historialAlimentoPorComida = new HistorialAlimentoPorComida();
                                    $historialAlimentoPorComida->HistorialAlimentoPorComidaEstado = 1;

                                    $historialAlimentoPorComida->HistorialComidaPorTipoPacienteId = $historialComidaPorTipoPaciente->HistorialComidaPorTipoPacienteId;
                                    $alimento = Alimento::findOrFail($alimentoPorComida->AlimentoId);
                                    $unidadMedida = UnidadMedida::findOrFail($alimentoPorComida->UnidadMedidaId);
                                    $historialAlimentoPorComida->AlimentoNombre = $alimento->AlimentoNombre;
                                    $historialAlimentoPorComida->AlimentoCantidad = $alimentoPorComida->AlimentoPorComidaCantidadNeto;
                                    $historialAlimentoPorComida->AlimentoUnidadMedida = $unidadMedida->UnidadMedidaNombre;
                                    //CAMBIA EN LA BD : en la tabla historialalimentoporcomida el campo AlimentoCosto a AlimentoCostoTotal
                                    $historialAlimentoPorComida->AlimentoCostoTotal = round($alimentoPorComida->AlimentoPorComidaCostoTotal, 2);
                                    $historialAlimentoPorComida->save();
                                    //Acumulo los costos totales de los campos padres
                                    $historialComidaPorTipoPaciente->ComidaCostoTotal += round($historialAlimentoPorComida->AlimentoCostoTotal, 2);
                                }
                                $historialComidaPorTipoPaciente->update();
                                $historialTipoPaciente->HistorialTipoPacienteCostoTotal += round($historialComidaPorTipoPaciente->ComidaCostoTotal, 2);
                            }
                        }
                        $historialTipoPaciente->Update();
                        $historial->HistorialCostoTotal += round($historialTipoPaciente->HistorialTipoPacienteCostoTotal, 2);   
                        $resultado = $historial->Update();
                    
                    }else{ //-----------Si es particular y el turno es a la tarde-------------
                        $historial = Historial::where('HistorialEstado',1)->where('HistorialFecha',$fecha)->where('HistorialTurno','Tarde')->first();
                        $historial->HistorialCantidadPacientes+=1;
                        $historialTipoPaciente = new HistorialTipoPaciente();
                        $historialTipoPaciente->HistorialId = $historial->HistorialId;
                        $historialTipoPaciente->HistorialTipoPacienteCantidad = 1; // VERIFICAR ESTO!
                        $historialTipoPaciente->HistorialTipoPacienteCostoTotal = 0;
                        $historialTipoPaciente->TipoPacienteNombre = 'Particular';
                        $historialTipoPaciente->PacienteId = $pacienteId;
                        $historialTipoPaciente->save();
                        $detalleMenuTipoPaciente = DetalleMenuTipoPaciente::where('MenuId',$menuParticular->MenuId)->first();
                            //Busco las comidas (solo cena - sopa - postre y desayuno)
                            $comidasPorTipoPaciente = ComidaPorTipoPaciente::where('DetalleMenuTipoPacienteId',$detalleMenuTipoPaciente->DetalleMenuTipoPacienteId)->get();
                            foreach ($comidasPorTipoPaciente as $comidaPorTipoPaciente) {
                                $tipoComida = TipoComida::findOrFail($comidaPorTipoPaciente->TipoComidaId);
                                $tipoComidaNombre = $tipoComida->TipoComidaNombre;
                                $comida = Comida::findOrFail($comidaPorTipoPaciente->ComidaId);
                                $comidaNombre = $comida->ComidaNombre;
                                if($tipoComidaNombre == 'Cena' or $tipoComidaNombre == 'Sopa Cena' or $tipoComidaNombre == 'Postre Cena' or $tipoComidaNombre == 'Desayuno'){
                                    $historialComidaPorTipoPaciente = new HistorialComidaPorTipoPaciente();
                                    $historialComidaPorTipoPaciente->HistorialComidaPorTipoPacienteEstado = 1;

                                    $historialComidaPorTipoPaciente->HistorialTipoPacienteId = $historialTipoPaciente->HistorialTipoPacienteId; 
                                    $historialComidaPorTipoPaciente->ComidaNombre = $comidaNombre;
                                    $historialComidaPorTipoPaciente->TipoComidaNombre = $tipoComidaNombre;
                                    $historialComidaPorTipoPaciente->ComidaCostoTotal = 0;
                                    $historialComidaPorTipoPaciente->save();
                                    //Busco los alimentos que componen esa comida
                                    $alimentosPorComida = AlimentoPorComida::where('ComidaId',$comidaPorTipoPaciente->ComidaId)->get();
                                    foreach ($alimentosPorComida as $alimentoPorComida) {
                                        $historialAlimentoPorComida = new HistorialAlimentoPorComida();
                                        $historialAlimentoPorComida->HistorialAlimentoPorComidaEstado = 1;
                                        
                                        $historialAlimentoPorComida->HistorialComidaPorTipoPacienteId = $historialComidaPorTipoPaciente->HistorialComidaPorTipoPacienteId;
                                        $alimento = Alimento::findOrFail($alimentoPorComida->AlimentoId);
                                        $unidadMedida = UnidadMedida::findOrFail($alimentoPorComida->UnidadMedidaId);
                                        $historialAlimentoPorComida->AlimentoNombre = $alimento->AlimentoNombre;
                                        $historialAlimentoPorComida->AlimentoCantidad = $alimentoPorComida->AlimentoPorComidaCantidadNeto;
                                        $historialAlimentoPorComida->AlimentoUnidadMedida = $unidadMedida->UnidadMedidaNombre;
                                        //CAMBIA EN LA BD : en la tabla historialalimentoporcomida el campo AlimentoCosto a AlimentoCostoTotal
                                        $historialAlimentoPorComida->AlimentoCostoTotal = round($alimentoPorComida->AlimentoPorComidaCostoTotal, 2);
                                        $historialAlimentoPorComida->save();
                                        //Acumulo los costos totales de los campos padres
                                        $historialComidaPorTipoPaciente->ComidaCostoTotal += round($historialAlimentoPorComida->AlimentoCostoTotal, 2);
                                    }
                                    $historialComidaPorTipoPaciente->update();
                                    $historialTipoPaciente->HistorialTipoPacienteCostoTotal += round($historialComidaPorTipoPaciente->ComidaCostoTotal, 2);
                                }
                            }
                            $historialTipoPaciente->Update();
                            $historial->HistorialCostoTotal += round($historialTipoPaciente->HistorialTipoPacienteCostoTotal, 2);   
                            $resultado = $historial->Update();
                        }
                }     
            }
        }else{
            //implementar un mecanismo de mensajes de respuestas posibles para el usuario.
            return response()->json(['success'=>'false','message'=>'No existe el relevamiento seleccionado.']);
        }
        if ($resultado) {
            return response()->json(['success'=>'true','message'=>'Se registró con éxito.','historialId'=>$historial->HistorialId]);
        }else{
            return response()->json(['success'=>'false','message'=>'Hubo un error.']);
        }
    }
    public function show($id)
    {
        $historial = Historial::findOrFail($id);
        $historialTipoPaciente = HistorialTipoPaciente::where('HistorialId',$historial->HistorialId)->get();
        if($historial->HistorialEstado){
            return view('historial.show', compact('historial','historialTipoPaciente'));
        }
        abort(404);
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
    {
        $historial = Historial::findOrFail($id);
        $historial->HistorialEstado = 0;
        $historial->update();
        $historialTiposPaciente = HistorialTipoPaciente::where("HistorialId",$historial->HistorialId)->get();
        foreach ($historialTiposPaciente as $historialTipoPaciente) {
            $historialTipoPaciente->HistorialTipoPacienteEstado = 0;
            $historialTipoPaciente->update();
            $historialComidasPorTipoPaciente = HistorialComidaPorTipoPaciente::where("HistorialTipoPacienteId",$historialTipoPaciente->HistorialTipoPacienteId)->get('HistorialTipoPacienteId',$historialTipoPaciente->HistorialTipoPacienteId);
            foreach ($historialComidasPorTipoPaciente as $historialComidaPorTipoPaciente) {
                $historialComidaPorTipoPaciente->HistorialComidaPorTipoPacienteEstado = 0;
                $historialComidaPorTipoPaciente->update();
                $historialAlimentosPorComida = HistorialAlimentoPorComida::where("HistorialComidaPorTipoPacienteId",$historialComidaPorTipoPaciente->HistorialComidaPorTipoPacienteId)->get();
                foreach ($historialAlimentosPorComida as $historialAlimentoPorComida) {
                    $historialAlimentoPorComida->HistorialAlimentoPorComidaEstado = 0;
                    $historialAlimentoPorComida->update();
                }
            }
        }

        return response()->json(['success'=>'true','message'=>'Se eliminó con éxito.','historialId'=>$historial->HistorialId]);

    }

}
