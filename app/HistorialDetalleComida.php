<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialDetalleComida extends Model
{
	protected $table = 'historialdetallecomida';
	protected $primaryKey = 'HistorialDetalleComidaId';
	protected $filliable=['HistorialId','ComidaNombre','Porciones','CostoTotal'];
	public $timestamps = false;
}
