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
        $cuil = $this->pacienteCuil;
        $fechaInicio = $this->relevamientoFechaIni;
        if($fechaInicio){
            $fechaInicio = new \DateTime();
            $fechaInicio->setTimestamp(strtotime($this->relevamientoFechaIni));
        }
        $fechaFin = $this->relevamientoFechaFin;
        if($fechaFin){
            $fechaFin = new \DateTime();
            $fechaFin->setTimestamp(strtotime($this->relevamientoFechaFin));
        }
        $sala = $this->salaId;

        $whereCuil          = false;
        $whereBetweenFecha  = false;
        $whereSala          = false;
        $whereFechaMayorQue = false;
        $whereFechaMenorQue = false;

        switch (true) {
            case ($cuil && $fechaInicio && $fechaFin && $sala):
                $whereCuil = true;
                $whereBetweenFecha = true;
                $whereSala = true;
                break;
            case ($cuil && !$fechaInicio && !$fechaFin && !$sala):
                $whereCuil = true;
                break;
            case (!$cuil && $fechaInicio && !$fechaFin && !$sala):
                $whereFechaMayorQue = true;
                break;
            case (!$cuil && !$fechaInicio && $fechaFin && !$sala):
                $whereFechaMenorQue = true;
                break;
            case (!$cuil && !$fechaInicio && !$fechaFin && $sala):
                $whereSala = true;
                break;
            case ($cuil && $fechaInicio && $fechaFin && !$sala):
                $whereCuil = true;
                $whereBetweenFecha = true;
                break;
            case ($cuil && $fechaInicio && !$fechaFin && $sala):
                $whereCuil = true;
                $whereFechaMayorQue = true;
                $whereSala = true;
                break;
            case ($cuil && !$fechaInicio && $fechaFin && $sala):
                $whereCuil = true;
                $whereFechaMenorQue = true;
                $whereSala = true;
                break;
            case (!$cuil && $fechaInicio && $fechaFin && $sala):
                $whereBetweenFecha = true;
                $whereSala = true;
                break;
            case ($cuil && $fechaInicio && !$fechaFin && !$sala):
                $whereCuil = true;
                $whereFechaMayorQue = true;
                break;
            case ($cuil && !$fechaInicio && $fechaFin && !$sala):
                $whereCuil = true;
                $whereFechaMenorQue = true;
                break;
            case ($cuil && !$fechaInicio && !$fechaFin && $sala):
                $whereCuil = true;
                $whereSala = true;
                break;
            case (!$cuil && $fechaInicio && $fechaFin && !$sala):
                $whereBetweenFecha = true;
                break;
            case (!$cuil && !$fechaInicio && $fechaFin && $sala):
                $whereFechaMenorQue = true;
                $whereSala = true;
                break;
            case (!$cuil && $fechaInicio && !$fechaFin && $sala):
                $whereFechaMayorQue = true;
                $whereSala = true;
                break;
            default:
                break;
        }

        $relevamientos = DB::table('detallerelevamiento as dr')
        ->join('relevamientoporsala as rps','rps.RelevamientoPorSalaId','dr.RelevamientoPorSalaId')
        ->join('relevamiento as r','r.RelevamientoId','rps.RelevamientoId')
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
            's.SalaId',
            's.SalaNombre',
        );

        $whereCuil          ? $relevamientos->where('p.PacienteCuil', '=' , $cuil) : '';
        $whereFechaMayorQue ? $relevamientos->where('r.RelevamientoFecha', '>=' , $fechaInicio) : '';
        $whereFechaMenorQue ? $relevamientos->where('r.RelevamientoFecha', '<=' , $fechaFin) : '';
        $whereBetweenFecha  ? $relevamientos->whereBetween('r.RelevamientoFecha',[$fechaInicio, $fechaFin]) : '';
        $whereSala          ? $relevamientos->where('s.SalaId','=',$sala) : '';

        return $relevamientos->get();

    }

}
