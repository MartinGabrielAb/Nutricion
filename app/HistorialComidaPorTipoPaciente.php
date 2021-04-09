<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialComidaPorTipoPaciente extends Model
{
	protected $table = 'historialcomidaportipopaciente';
	protected $primaryKey = 'HistorialComidaPorTipoPacienteId';
	protected $filliable=['ComidaNombre','TipoComidaNombre','ComidaCostoTotal','HistorialTipoPacienteId'];
	public $timestamps = false;
}
