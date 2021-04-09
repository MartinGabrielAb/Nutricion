<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
	protected $table = 'paciente';
	protected $primaryKey = 'PacienteId';
	public $timestamps = false;
	protected $filliable=['PersonaId','PacienteEstado'];
}