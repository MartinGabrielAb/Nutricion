<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profesional extends Model
{
    protected $table = 'profesional';
	protected $primaryKey = 'ProfesionalId';
	public $timestamps = false;
	protected $filliable=['ProfesionaMatricula','ProfesionalEstado','EmpleadoId'];
}
