<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RelevamientosExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($pacienteCuil, $relevamientoFechaIni, $relevamientoFechaFin, $salaId)
    {
        $this->pacienteCuil = $pacienteCuil;
        $this->relevamientoFechaIni = $relevamientoFechaIni;
        $this->relevamientoFechaFin = $relevamientoFechaFin;
        $this->salaId = $salaId;
    }

    public function headings(): array{
        return [
            'Nombre',
            'DNI',
            'Fecha y Hora',
            'Turno',
            'Diagnóstico',
            'Menú',
            'Regímen',
            'Observaciones',
            'Acompañante',
            'Vajilla descartable',
            'Cama',
            'Pieza',
            'Sala',
        ]; 
    }
    public function collection()
    {
        if($this->pacienteCuil != null && $this->relevamientoFechaIni != null && $this->relevamientoFechaFin != null && $this->salaId != null){
            return DB::table('detallerelevamiento as dr')
                        ->join('relevamiento as r','r.RelevamientoId','dr.RelevamientoId')
                        ->join('paciente as p','p.PacienteId','dr.PacienteId')
                        ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                        ->join('menu as m','m.MenuId','dr.MenuId')
                        ->join('cama as c','c.CamaId','dr.CamaId')
                        ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                        ->join('sala as s','s.SalaId','pi.SalaId')
                        ->select(
                            'p.PacienteNombre',
                            'p.PacienteCuil',
                            'dr.updated_at',
                            'r.RelevamientoTurno',
                            'dr.DetalleRelevamientoDiagnostico',
                            'm.MenuNombre',
                            'tp.TipoPacienteNombre',
                            'dr.DetalleRelevamientoObservaciones',
                            'dr.DetalleRelevamientoAcompaniante',
                            'dr.DetalleRelevamientoVajillaDescartable',
                            'c.CamaNumero',
                            'pi.PiezaNombre',
                            's.SalaNombre',
                        )
                        ->where('p.PacienteCuil',$this->pacienteCuil)
                        ->whereBetween('r.RelevamientoFecha', [$this->relevamientoFechaIni, $this->relevamientoFechaFin])
                        ->where('s.SalaId',$this->salaId)
                        ->get();
        }elseif($this->pacienteCuil != null && $this->relevamientoFechaIni == null && $this->relevamientoFechaFin == null && $this->salaId == null){
            
            return DB::table('detallerelevamiento as dr')
                        ->join('relevamiento as r','r.RelevamientoId','dr.RelevamientoId')
                        ->join('paciente as p','p.PacienteId','dr.PacienteId')
                        ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                        ->join('menu as m','m.MenuId','dr.MenuId')
                        ->join('cama as c','c.CamaId','dr.CamaId')
                        ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                        ->join('sala as s','s.SalaId','pi.SalaId')
                        ->select(
                            'p.PacienteNombre',
                            'p.PacienteCuil',
                            'dr.updated_at',
                            'r.RelevamientoTurno',
                            'dr.DetalleRelevamientoDiagnostico',
                            'm.MenuNombre',
                            'tp.TipoPacienteNombre',
                            'dr.DetalleRelevamientoObservaciones',
                            'dr.DetalleRelevamientoAcompaniante',
                            'dr.DetalleRelevamientoVajillaDescartable',
                            'c.CamaNumero',
                            'pi.PiezaNombre',
                            's.SalaNombre',
                        )
                        ->where('p.PacienteCuil',$this->pacienteCuil)
                        ->get();
        }elseif($this->pacienteCuil == null && $this->relevamientoFechaIni != null && $this->relevamientoFechaFin == null && $this->salaId == null){
            return DB::table('detallerelevamiento as dr')
                        ->join('relevamiento as r','r.RelevamientoId','dr.RelevamientoId')
                        ->join('paciente as p','p.PacienteId','dr.PacienteId')
                        ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                        ->join('menu as m','m.MenuId','dr.MenuId')
                        ->join('cama as c','c.CamaId','dr.CamaId')
                        ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                        ->join('sala as s','s.SalaId','pi.SalaId')
                        ->select(
                            'p.PacienteNombre',
                            'p.PacienteCuil',
                            'dr.updated_at',
                            'r.RelevamientoTurno',
                            'dr.DetalleRelevamientoDiagnostico',
                            'm.MenuNombre',
                            'tp.TipoPacienteNombre',
                            'dr.DetalleRelevamientoObservaciones',
                            'dr.DetalleRelevamientoAcompaniante',
                            'dr.DetalleRelevamientoVajillaDescartable',
                            'c.CamaNumero',
                            'pi.PiezaNombre',
                            's.SalaNombre',
                        )
                        ->where('r.RelevamientoFecha', $this->relevamientoFechaIni)
                        ->get();
        }elseif($this->pacienteCuil == null && $this->relevamientoFechaIni == null && $this->relevamientoFechaFin != null && $this->salaId == null){
            return DB::table('detallerelevamiento as dr')
                        ->join('relevamiento as r','r.RelevamientoId','dr.RelevamientoId')
                        ->join('paciente as p','p.PacienteId','dr.PacienteId')
                        ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                        ->join('menu as m','m.MenuId','dr.MenuId')
                        ->join('cama as c','c.CamaId','dr.CamaId')
                        ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                        ->join('sala as s','s.SalaId','pi.SalaId')
                        ->select(
                            'p.PacienteNombre',
                            'p.PacienteCuil',
                            'dr.updated_at',
                            'r.RelevamientoTurno',
                            'dr.DetalleRelevamientoDiagnostico',
                            'm.MenuNombre',
                            'tp.TipoPacienteNombre',
                            'dr.DetalleRelevamientoObservaciones',
                            'dr.DetalleRelevamientoAcompaniante',
                            'dr.DetalleRelevamientoVajillaDescartable',
                            'c.CamaNumero',
                            'pi.PiezaNombre',
                            's.SalaNombre',
                        )
                        ->where('r.RelevamientoFecha', $this->relevamientoFechaFin)
                        ->get();
        }elseif($this->pacienteCuil == null && $this->relevamientoFechaIni == null && $this->relevamientoFechaFin == null && $this->salaId != null){
            return DB::table('detallerelevamiento as dr')
                        ->join('relevamiento as r','r.RelevamientoId','dr.RelevamientoId')
                        ->join('paciente as p','p.PacienteId','dr.PacienteId')
                        ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                        ->join('menu as m','m.MenuId','dr.MenuId')
                        ->join('cama as c','c.CamaId','dr.CamaId')
                        ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                        ->join('sala as s','s.SalaId','pi.SalaId')
                        ->select(
                            'p.PacienteNombre',
                            'p.PacienteCuil',
                            'dr.updated_at',
                            'r.RelevamientoTurno',
                            'dr.DetalleRelevamientoDiagnostico',
                            'm.MenuNombre',
                            'tp.TipoPacienteNombre',
                            'dr.DetalleRelevamientoObservaciones',
                            'dr.DetalleRelevamientoAcompaniante',
                            'dr.DetalleRelevamientoVajillaDescartable',
                            'c.CamaNumero',
                            'pi.PiezaNombre',
                            's.SalaNombre',
                        )
                        ->where('s.SalaId',$this->salaId)
                        ->get();
        }elseif($this->pacienteCuil != null && $this->relevamientoFechaIni != null && $this->relevamientoFechaFin != null && $this->salaId == null){
            return DB::table('detallerelevamiento as dr')
                        ->join('relevamiento as r','r.RelevamientoId','dr.RelevamientoId')
                        ->join('paciente as p','p.PacienteId','dr.PacienteId')
                        ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                        ->join('menu as m','m.MenuId','dr.MenuId')
                        ->join('cama as c','c.CamaId','dr.CamaId')
                        ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                        ->join('sala as s','s.SalaId','pi.SalaId')
                        ->select(
                            'p.PacienteNombre',
                            'p.PacienteCuil',
                            'dr.updated_at',
                            'r.RelevamientoTurno',
                            'dr.DetalleRelevamientoDiagnostico',
                            'm.MenuNombre',
                            'tp.TipoPacienteNombre',
                            'dr.DetalleRelevamientoObservaciones',
                            'dr.DetalleRelevamientoAcompaniante',
                            'dr.DetalleRelevamientoVajillaDescartable',
                            'c.CamaNumero',
                            'pi.PiezaNombre',
                            's.SalaNombre',
                        )
                        ->where('p.PacienteCuil',$this->pacienteCuil)
                        ->whereBetween('r.RelevamientoFecha', [$this->relevamientoFechaIni, $this->relevamientoFechaFin])
                        ->get();
        }elseif($this->pacienteCuil != null && $this->relevamientoFechaIni != null && $this->relevamientoFechaFin == null && $this->salaId != null){
            return DB::table('detallerelevamiento as dr')
                        ->join('relevamiento as r','r.RelevamientoId','dr.RelevamientoId')
                        ->join('paciente as p','p.PacienteId','dr.PacienteId')
                        ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                        ->join('menu as m','m.MenuId','dr.MenuId')
                        ->join('cama as c','c.CamaId','dr.CamaId')
                        ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                        ->join('sala as s','s.SalaId','pi.SalaId')
                        ->select(
                            'p.PacienteNombre',
                            'p.PacienteCuil',
                            'dr.updated_at',
                            'r.RelevamientoTurno',
                            'dr.DetalleRelevamientoDiagnostico',
                            'm.MenuNombre',
                            'tp.TipoPacienteNombre',
                            'dr.DetalleRelevamientoObservaciones',
                            'dr.DetalleRelevamientoAcompaniante',
                            'dr.DetalleRelevamientoVajillaDescartable',
                            'c.CamaNumero',
                            'pi.PiezaNombre',
                            's.SalaNombre',
                        )
                        ->where('p.PacienteCuil',$this->pacienteCuil)
                        ->where('r.RelevamientoFecha', $this->relevamientoFechaIni)
                        ->where('s.SalaId',$this->salaId)
                        ->get();
        }elseif($this->pacienteCuil != null && $this->relevamientoFechaIni == null && $this->relevamientoFechaFin != null && $this->salaId != null){
            return DB::table('detallerelevamiento as dr')
                        ->join('relevamiento as r','r.RelevamientoId','dr.RelevamientoId')
                        ->join('paciente as p','p.PacienteId','dr.PacienteId')
                        ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                        ->join('menu as m','m.MenuId','dr.MenuId')
                        ->join('cama as c','c.CamaId','dr.CamaId')
                        ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                        ->join('sala as s','s.SalaId','pi.SalaId')
                        ->select(
                            'p.PacienteNombre',
                            'p.PacienteCuil',
                            'dr.updated_at',
                            'r.RelevamientoTurno',
                            'dr.DetalleRelevamientoDiagnostico',
                            'm.MenuNombre',
                            'tp.TipoPacienteNombre',
                            'dr.DetalleRelevamientoObservaciones',
                            'dr.DetalleRelevamientoAcompaniante',
                            'dr.DetalleRelevamientoVajillaDescartable',
                            'c.CamaNumero',
                            'pi.PiezaNombre',
                            's.SalaNombre',
                        )
                        ->where('p.PacienteCuil',$this->pacienteCuil)
                        ->where('r.RelevamientoFecha', $this->relevamientoFechaFin)
                        ->where('s.SalaId',$this->salaId)
                        ->get();
        }elseif($this->pacienteCuil == null && $this->relevamientoFechaIni != null && $this->relevamientoFechaFin != null && $this->salaId != null){
            return DB::table('detallerelevamiento as dr')
                        ->join('relevamiento as r','r.RelevamientoId','dr.RelevamientoId')
                        ->join('paciente as p','p.PacienteId','dr.PacienteId')
                        ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                        ->join('menu as m','m.MenuId','dr.MenuId')
                        ->join('cama as c','c.CamaId','dr.CamaId')
                        ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                        ->join('sala as s','s.SalaId','pi.SalaId')
                        ->select(
                            'p.PacienteNombre',
                            'p.PacienteCuil',
                            'dr.updated_at',
                            'r.RelevamientoTurno',
                            'dr.DetalleRelevamientoDiagnostico',
                            'm.MenuNombre',
                            'tp.TipoPacienteNombre',
                            'dr.DetalleRelevamientoObservaciones',
                            'dr.DetalleRelevamientoAcompaniante',
                            'dr.DetalleRelevamientoVajillaDescartable',
                            'c.CamaNumero',
                            'pi.PiezaNombre',
                            's.SalaNombre',
                        )
                        ->whereBetween('r.RelevamientoFecha', [$this->relevamientoFechaIni, $this->relevamientoFechaFin])
                        ->where('s.SalaId',$this->salaId)
                        ->get();
        }elseif($this->pacienteCuil != null && $this->relevamientoFechaIni != null && $this->relevamientoFechaFin == null && $this->salaId == null){
            return DB::table('detallerelevamiento as dr')
                        ->join('relevamiento as r','r.RelevamientoId','dr.RelevamientoId')
                        ->join('paciente as p','p.PacienteId','dr.PacienteId')
                        ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                        ->join('menu as m','m.MenuId','dr.MenuId')
                        ->join('cama as c','c.CamaId','dr.CamaId')
                        ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                        ->join('sala as s','s.SalaId','pi.SalaId')
                        ->select(
                            'p.PacienteNombre',
                            'p.PacienteCuil',
                            'dr.updated_at',
                            'r.RelevamientoTurno',
                            'dr.DetalleRelevamientoDiagnostico',
                            'm.MenuNombre',
                            'tp.TipoPacienteNombre',
                            'dr.DetalleRelevamientoObservaciones',
                            'dr.DetalleRelevamientoAcompaniante',
                            'dr.DetalleRelevamientoVajillaDescartable',
                            'c.CamaNumero',
                            'pi.PiezaNombre',
                            's.SalaNombre',
                        )
                        ->where('p.PacienteCuil',$this->pacienteCuil)
                        ->where('r.RelevamientoFecha', $this->relevamientoFechaIni)
                        ->get();
        }elseif($this->pacienteCuil != null && $this->relevamientoFechaIni == null && $this->relevamientoFechaFin != null && $this->salaId == null){
            return DB::table('detallerelevamiento as dr')
                        ->join('relevamiento as r','r.RelevamientoId','dr.RelevamientoId')
                        ->join('paciente as p','p.PacienteId','dr.PacienteId')
                        ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                        ->join('menu as m','m.MenuId','dr.MenuId')
                        ->join('cama as c','c.CamaId','dr.CamaId')
                        ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                        ->join('sala as s','s.SalaId','pi.SalaId')
                        ->select(
                            'p.PacienteNombre',
                            'p.PacienteCuil',
                            'dr.updated_at',
                            'r.RelevamientoTurno',
                            'dr.DetalleRelevamientoDiagnostico',
                            'm.MenuNombre',
                            'tp.TipoPacienteNombre',
                            'dr.DetalleRelevamientoObservaciones',
                            'dr.DetalleRelevamientoAcompaniante',
                            'dr.DetalleRelevamientoVajillaDescartable',
                            'c.CamaNumero',
                            'pi.PiezaNombre',
                            's.SalaNombre',
                        )
                        ->where('p.PacienteCuil',$this->pacienteCuil)
                        ->where('r.RelevamientoFecha', $this->relevamientoFechaFin)
                        ->get();
        }elseif($this->pacienteCuil != null && $this->relevamientoFechaIni == null && $this->relevamientoFechaFin == null && $this->salaId != null){
            return DB::table('detallerelevamiento as dr')
                        ->join('relevamiento as r','r.RelevamientoId','dr.RelevamientoId')
                        ->join('paciente as p','p.PacienteId','dr.PacienteId')
                        ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                        ->join('menu as m','m.MenuId','dr.MenuId')
                        ->join('cama as c','c.CamaId','dr.CamaId')
                        ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                        ->join('sala as s','s.SalaId','pi.SalaId')
                        ->select(
                            'p.PacienteNombre',
                            'p.PacienteCuil',
                            'dr.updated_at',
                            'r.RelevamientoTurno',
                            'dr.DetalleRelevamientoDiagnostico',
                            'm.MenuNombre',
                            'tp.TipoPacienteNombre',
                            'dr.DetalleRelevamientoObservaciones',
                            'dr.DetalleRelevamientoAcompaniante',
                            'dr.DetalleRelevamientoVajillaDescartable',
                            'c.CamaNumero',
                            'pi.PiezaNombre',
                            's.SalaNombre',
                        )
                        ->where('p.PacienteCuil',$this->pacienteCuil)
                        ->where('s.SalaId',$this->salaId)
                        ->get();
        }elseif($this->pacienteCuil == null && $this->relevamientoFechaIni != null && $this->relevamientoFechaFin != null && $this->salaId == null){
            return DB::table('detallerelevamiento as dr')
                        ->join('relevamiento as r','r.RelevamientoId','dr.RelevamientoId')
                        ->join('paciente as p','p.PacienteId','dr.PacienteId')
                        ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                        ->join('menu as m','m.MenuId','dr.MenuId')
                        ->join('cama as c','c.CamaId','dr.CamaId')
                        ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                        ->join('sala as s','s.SalaId','pi.SalaId')
                        ->select(
                            'p.PacienteNombre',
                            'p.PacienteCuil',
                            'dr.updated_at',
                            'r.RelevamientoTurno',
                            'dr.DetalleRelevamientoDiagnostico',
                            'm.MenuNombre',
                            'tp.TipoPacienteNombre',
                            'dr.DetalleRelevamientoObservaciones',
                            'dr.DetalleRelevamientoAcompaniante',
                            'dr.DetalleRelevamientoVajillaDescartable',
                            'c.CamaNumero',
                            'pi.PiezaNombre',
                            's.SalaNombre',
                        )
                        ->whereBetween('r.RelevamientoFecha', [$this->relevamientoFechaIni, $this->relevamientoFechaFin])
                        ->get();
        }elseif($this->pacienteCuil == null && $this->relevamientoFechaIni == null && $this->relevamientoFechaFin != null && $this->salaId != null){
            return DB::table('detallerelevamiento as dr')
                        ->join('relevamiento as r','r.RelevamientoId','dr.RelevamientoId')
                        ->join('paciente as p','p.PacienteId','dr.PacienteId')
                        ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                        ->join('menu as m','m.MenuId','dr.MenuId')
                        ->join('cama as c','c.CamaId','dr.CamaId')
                        ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                        ->join('sala as s','s.SalaId','pi.SalaId')
                        ->select(
                            'p.PacienteNombre',
                            'p.PacienteCuil',
                            'dr.updated_at',
                            'r.RelevamientoTurno',
                            'dr.DetalleRelevamientoDiagnostico',
                            'm.MenuNombre',
                            'tp.TipoPacienteNombre',
                            'dr.DetalleRelevamientoObservaciones',
                            'dr.DetalleRelevamientoAcompaniante',
                            'dr.DetalleRelevamientoVajillaDescartable',
                            'c.CamaNumero',
                            'pi.PiezaNombre',
                            's.SalaNombre',
                        )
                        ->where('r.RelevamientoFecha', $this->relevamientoFechaFin)
                        ->where('s.SalaId',$this->salaId)
                        ->get();
        }elseif($this->pacienteCuil == null && $this->relevamientoFechaIni != null && $this->relevamientoFechaFin == null && $this->salaId != null){
            return DB::table('detallerelevamiento as dr')
                        ->join('relevamiento as r','r.RelevamientoId','dr.RelevamientoId')
                        ->join('paciente as p','p.PacienteId','dr.PacienteId')
                        ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                        ->join('menu as m','m.MenuId','dr.MenuId')
                        ->join('cama as c','c.CamaId','dr.CamaId')
                        ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                        ->join('sala as s','s.SalaId','pi.SalaId')
                        ->select(
                            'p.PacienteNombre',
                            'p.PacienteCuil',
                            'dr.updated_at',
                            'r.RelevamientoTurno',
                            'dr.DetalleRelevamientoDiagnostico',
                            'm.MenuNombre',
                            'tp.TipoPacienteNombre',
                            'dr.DetalleRelevamientoObservaciones',
                            'dr.DetalleRelevamientoAcompaniante',
                            'dr.DetalleRelevamientoVajillaDescartable',
                            'c.CamaNumero',
                            'pi.PiezaNombre',
                            's.SalaNombre',
                        )
                        ->where('r.RelevamientoFecha', $this->relevamientoFechaIni)
                        ->where('s.SalaId',$this->salaId)
                        ->get();
        }elseif($this->pacienteCuil == null && $this->relevamientoFechaIni == null && $this->relevamientoFechaFin == null && $this->salaId == null){
            return DB::table('detallerelevamiento as dr')
                        ->join('relevamiento as r','r.RelevamientoId','dr.RelevamientoId')
                        ->join('paciente as p','p.PacienteId','dr.PacienteId')
                        ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                        ->join('menu as m','m.MenuId','dr.MenuId')
                        ->join('cama as c','c.CamaId','dr.CamaId')
                        ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                        ->join('sala as s','s.SalaId','pi.SalaId')
                        ->select(
                            'p.PacienteNombre',
                            'p.PacienteCuil',
                            'dr.updated_at',
                            'r.RelevamientoTurno',
                            'dr.DetalleRelevamientoDiagnostico',
                            'm.MenuNombre',
                            'tp.TipoPacienteNombre',
                            'dr.DetalleRelevamientoObservaciones',
                            'dr.DetalleRelevamientoAcompaniante',
                            'dr.DetalleRelevamientoVajillaDescartable',
                            'c.CamaNumero',
                            'pi.PiezaNombre',
                            's.SalaNombre',
                        )
                        ->get();
        }
    }
}
