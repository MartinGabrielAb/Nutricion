<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NutrientePorAlimento extends Model
{
    protected $table = 'nutrienteporalimento';
	protected $primaryKey = 'NutrientePorAlimentoId';
	public $timestamps = false;
	protected $filliable=['AlimentoId','NutrienteId','NutrientePorAlimentoValor','NutrientePorAlimentoEstado'];

}