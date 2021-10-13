<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialDetalleAlimento extends Model
{
	protected $table = 'historialdetallealimento';
	protected $primaryKey = 'HistorialDetalleAlimentoId';
	protected $filliable=['HistorialDetalleComidaId','AlimentoId','AlimentoNombre','UnidadMedida','Cantidad','CostoTotal'];
	public $timestamps = false;
}
