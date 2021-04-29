<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetRelevamientoPorComida extends Model
{
    protected $table = 'detrelevamientoporcomida';
  	protected $primaryKey = 'DetRelevamientoPorComidaId';
  	protected $filliable=['DetalleRelevamientoId','ComidaId'];
  	public $timestamps = false;
}
