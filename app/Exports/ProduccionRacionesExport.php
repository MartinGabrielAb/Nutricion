<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProduccionRacionesExport implements FromCollection, WithHeadings
{
    public function __construct($pacienteCuil, $relevamientoFechaIni, $relevamientoFechaFin, $salaId)
    {
        $this->pacienteCuil = $pacienteCuil;
        $this->relevamientoFechaIni = $relevamientoFechaIni;
        $this->relevamientoFechaFin = $relevamientoFechaFin;
        $this->salaId = $salaId;
    }
    
    public function headings(): array{
        return [
            'Regímen',
            'Cantidad',
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
        
        $detallesrelevamiento = DB::table('detallerelevamiento as dr')
                                ->join('relevamientoporsala as rps','rps.RelevamientoPorSalaId','dr.RelevamientoPorSalaId')
                                ->join('relevamiento as r','r.RelevamientoId','rps.RelevamientoId')
                                ->join('paciente as p','p.PacienteId','dr.PacienteId')
                                ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                                ->join('cama as c','c.CamaId','dr.CamaId')
                                ->join('pieza as pi','pi.PiezaId','c.PiezaId')
                                ->join('sala as s','s.SalaId','pi.SalaId');
                                
        $whereCuil          ? $detallesrelevamiento->where('p.PacienteCuil', '=' , $cuil) : '';
        $whereFechaMayorQue ? $detallesrelevamiento->where('r.RelevamientoFecha', '>=' , $fechaInicio) : '';
        $whereFechaMenorQue ? $detallesrelevamiento->where('r.RelevamientoFecha', '<=' , $fechaFin) : '';
        $whereBetweenFecha  ? $detallesrelevamiento->whereBetween('r.RelevamientoFecha',[$fechaInicio, $fechaFin]) : '';
        $whereSala          ? $detallesrelevamiento->where('s.SalaId','=',$sala) : '';
        
        $detallesrelevamiento = $detallesrelevamiento->get();
        
        $tiposPacienteAcumulados = collect([]);
        
        $tipospaciente = DB::table('tipopaciente')->where('TipoPacienteEstado',1)->get();
        
        foreach ($detallesrelevamiento as $detallerelevamiento) {
            foreach ($tipospaciente as $tipopaciente) {
                $encontrado = false;
                
                if($detallerelevamiento->TipoPacienteId == $tipopaciente->TipoPacienteId){
                    foreach ($tiposPacienteAcumulados as $key => $tipoPacienteAcumulados) {
                        if($tipoPacienteAcumulados[0] == $tipopaciente->TipoPacienteNombre){
                            $tiposPacienteAcumulados = $tiposPacienteAcumulados->replace([$key => [$tipoPacienteAcumulados[0],$tipoPacienteAcumulados[1] + 1]]);
                            $encontrado = true;
                            break;
                        }else{
                            $encontrado = false;
                        }
                    }
                    if (!$encontrado) {
                        $tiposPacienteAcumulados->push([$detallerelevamiento->TipoPacienteNombre,1]);
                    }
                    break;
                }
            }
        }
        
        return $tiposPacienteAcumulados;
    }
}
