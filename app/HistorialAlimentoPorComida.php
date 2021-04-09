<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialAlimentoPorComida extends Model
{
	protected $table = 'historialalimentoporcomida';
	protected $primaryKey = 'HistorialAlimentoPorComidaId ';
	protected $filliable=['AlimentoNombre','AlimentoCantidad','AlimentoUnidadMedida','AlimentoCosto','HistorialComidaPorTipoPacienteId'];
	public $timestamps = false;
}
