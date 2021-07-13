<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    protected $table = 'historial';
	protected $primaryKey = 'HistorialId';
	public $timestamps = false;
	protected $filliable=['RelevamientoId','HistorialCostoTotal'];

	}
