<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
	protected $table = 'persona';
	protected $primaryKey = 'PersonaId';
	public $timestamps = false;
	protected $filliable=['PersonaNombre','PersonaApellido','PersonaDireccion','PersonaEmail','PersonaTelefono','PersonaCuil','PersonaSexo','PersonaEstado'];
}