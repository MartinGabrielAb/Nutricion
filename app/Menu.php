<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';
	protected $primaryKey = 'MenuId';
	public $timestamps = false;
	protected $filliable=['MenuFecha','TipoPacienteId','MenuEstado','PacienteId','MenuParticular'];

	
}
