<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialTipoPaciente extends Model
{
	protected $table = 'historialtipopaciente';
	protected $primaryKey = 'HistorialTipoPacienteId';
	protected $filliable=['HistorialId','TipoPacienteNombre','HistorialTipoPacienteCantidad','HistorialTipoPacienteCostoTotal','HistorialTipoPacienteEstado','PacienteId'];
	public $timestamps = false;
}
