<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleMenuTipoPaciente extends Model
{
  	protected $table = 'detallemenutipopaciente';
  	protected $primaryKey = 'DetalleMenuTipoPacienteId';
  	protected $filliable=['DetalleMenuTipoPacienteCostoTotal','MenuId','TipoPacienteId'];
  	public $timestamps = false;
}
