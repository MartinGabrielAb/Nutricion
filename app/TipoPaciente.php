<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPaciente extends Model
{
    protected $table = 'tipopaciente';
    protected $primaryKey = 'TipoPacienteId';
    protected $filliable=['TipoPacienteNombre','TipoPacienteEstado'];
	public $timestamps = false;
}