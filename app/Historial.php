<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    protected $table = 'historial';
	protected $primaryKey = 'HistorialId';
	public $timestamps = false;
	protected $filliable=['HistorialFecha','HistorialCostoTotal','MenuNombre','HistorialEstado','HistorialTurno','HistorialCantidadPacientes'];

	}
