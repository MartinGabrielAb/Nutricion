<?php

namespace App\Http\Controllers;

use App\Menu;
use Exception;
use App\Paciente;
use App\Relevamiento;
use App\TipoPaciente;
use App\RelevamientoPorSala;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class RelevamientoPorSalaController extends Controller
{
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id ,Request $request)
    {
        /*---Pregunto si es una peticion ajax----*/
        if($request->ajax()){
            try{
                $detalles_relevamiento_sala = 
                    DB::table('detallerelevamiento as dr')
                    ->join('cama as c','c.CamadId','dr.CamaId')
                    ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                    ->join('sala as s','s.SalaId','pi.SalaId')
                    ->where('DetalleRelevamiento',1)->get();
                return DataTables::of($detalles_relevamiento_sala)
                            ->addColumn('btn','relevamientos/actions_show')
                            ->rawColumns(['btn'])
                            ->toJson();
            }catch(Exception $ex){
                return response()->json([
                    'error' => $ex->getMessage()
                ], 500);
            }
        }
        $relevamientoPorSala = RelevamientoPorSala::findOrFail($id);
        $relevamiento = Relevamiento::findOrFail($relevamientoPorSala->RelevamientoId);
        $menuSeleccionado = Menu::findOrFail($relevamiento->RelevamientoMenu);
        $relevamiento_por_salas = DB::table('relevamientoporsala as rps')  
                        ->join('relevamiento as r','r.RelevamientoId','rps.RelevamientoId')
                        ->join('sala as s','s.SalaId','rps.SalaId')
                        ->where('rps.RelevamientoPorSalaId',$id)
                        ->select('rps.RelevamientoPorSalaId','r.RelevamientoId',DB::raw('DATE_FORMAT(r.RelevamientoFecha, "%d/%m/%Y") as RelevamientoFecha'),'rps.SalaId','s.SalaPseudonimo','r.RelevamientoTurno')
                        ->first();
        //datos necesarios para agregar y editar un detalle de relevamiento
        $pacientes = Paciente::where('PacienteEstado','!=',-1)
                            ->select('PacienteId','PacienteApellido','PacienteNombre','PacienteCuil')
                            ->get();
        $piezas = DB::table('sala as s')
                    ->join('pieza as p','p.SalaId','s.SalaId')
                    ->where('s.SalaId',$relevamiento_por_salas->SalaId)
                    ->where('s.SalaEstado','1')
                    ->where('p.PiezaEstado','1')
                    ->orderby('s.SalaNombre','desc')
                    ->orderby('p.PiezaNombre','asc')
                    ->get();
        $tiposPaciente = TipoPaciente::all();
        $menus = Menu::where('MenuEstado',1)->get();
        $tiposcomida = DB::table('tipocomida')->where('TipoComidaEstado',1)->get();
        
        foreach ($tiposcomida as $index => $tipocomida) {
            $comidas = DB::table('comida as c')
                        ->join('comidaportipopaciente as cptp','cptp.ComidaId','c.ComidaId')
                        ->join('detallemenutipopaciente as dmtp','dmtp.DetalleMenuTipoPacienteId','cptp.DetalleMenuTipoPacienteId')
                        ->where('dmtp.MenuId',$menuSeleccionado->MenuId)
                        ->where('c.TipoComidaId',$tipocomida->TipoComidaId)
                        ->where('c.ComidaEstado',1)->get();
            $tiposcomida[$index]->comidas = $comidas;
        }

        $colaciones = DB::table('comida as c')
                        ->join('tipocomida as tc','tc.TipoComidaId','c.TipoComidaId')
                        // ->where('tc.TipoComidaNombre','Colación')
                        ->where('tc.TipoComidaNombre', 'like', '%Colación%')
                        ->get();

        return view('relevamientoporsalas.show',compact('relevamiento_por_salas','pacientes','piezas','tiposPaciente','menus','tiposcomida','colaciones','menuSeleccionado'));
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
        //
    }
}
