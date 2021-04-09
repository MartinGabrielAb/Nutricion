<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comida extends Model
{
    protected $table = 'comida';
	protected $primaryKey = 'ComidaId';
	public $timestamps = false;
	protected $filliable=['ComidaId','ComidaNombre','TipoComidaId','MenuId','ComidaEstado'];
}
