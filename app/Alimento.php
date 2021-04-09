<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alimento extends Model
{
    protected $table = 'alimento';
	protected $primaryKey = 'AlimentoId';
	public $timestamps = false;
	protected $filliable=['AlimentoId','AlimentoNombre','Despensa_DespensaId','AlimentoStock','AlimentoVencimiento','AlimentoEstado'];
}