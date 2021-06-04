<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alimento extends Model
{
	/*Cambio asd*/
    protected $table = 'alimento';
	protected $primaryKey = 'AlimentoId';
	public $timestamps = false;
	protected $filliable=['AlimentoId','AlimentoNombre','AlimentoCantidadTotal','UnidadMedidaId','AlimentoCostoTotal','AlimentoEstado'];
}