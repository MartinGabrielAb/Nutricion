<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoComida extends Model
{
     protected $table = 'tipocomida';
  	protected $primaryKey = 'TipoComidaId';
	public $timestamps = false;

}
