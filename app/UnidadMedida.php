<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    protected $table = 'unidadmedida';
  	protected $primaryKey = 'UnidadMedidaId';
	public $timestamps = false;

  	protected $filliable=['UnidadMedidaNombre'];
}