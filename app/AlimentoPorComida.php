<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlimentoPorComida extends Model
{
    protected $table = 'alimentoporcomida';
	protected $primaryKey = 'AlimentoPorComidaId';
	public $timestamps = false;
	protected $filliable=['ComidaId','AlimentoId','AlimentoPorComidaCantidadCocido','AlimentoPorComidaCantidadCrudo','AlimentoPorComidaEstado'];
}