<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProduccionRacionesExport implements FromCollection, WithHeadings
{
    public function __construct($relevamientoFechaIni, $relevamientoFechaFin)
    {
        $this->relevamientoFechaIni = $relevamientoFechaIni;
        $this->relevamientoFechaFin = $relevamientoFechaFin;
    }
    
    public function headings(): array{
        return [
            'Regímen',
            'Cantidad',
        ]; 
    }

    public function collection()
    {
        if($this->relevamientoFechaIni != null && $this->relevamientoFechaFin != null){
            $detallesrelevamiento = DB::table('detallerelevamiento as dr')
                                  ->join('relevamiento as r','r.RelevamientoId','dr.RelevamientoId')
                                  ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                                  ->whereBetween('r.RelevamientoFecha',[$this->relevamientoFechaIni,$this->relevamientoFechaFin])
                                  ->get();
        }elseif($this->relevamientoFechaIni == null && $this->relevamientoFechaFin == null){
            $detallesrelevamiento = DB::table('detallerelevamiento as dr')
                                  ->join('relevamiento as r','r.RelevamientoId','dr.RelevamientoId')
                                  ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                                  ->get();
        }elseif($this->relevamientoFechaIni != null && $this->relevamientoFechaFin == null){
            $detallesrelevamiento = DB::table('detallerelevamiento as dr')
                                  ->join('relevamiento as r','r.RelevamientoId','dr.RelevamientoId')
                                  ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                                  ->where('r.RelevamientoFecha',$this->relevamientoFechaIni)
                                  ->get();
        }else{
            $detallesrelevamiento = DB::table('detallerelevamiento as dr')
                                  ->join('relevamiento as r','r.RelevamientoId','dr.RelevamientoId')
                                  ->join('tipopaciente as tp','tp.TipoPacienteId','dr.TipoPacienteId')
                                  ->where('r.RelevamientoFecha',$this->relevamientoFechaFin)
                                  ->get();
        }
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
