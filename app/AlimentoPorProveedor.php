<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlimentoPorProveedor extends Model
{
    protected $table = 'alimentoporproveedor';
	protected $primaryKey = 'AlimentoPorProveedorId';
	public $timestamps = false;
	protected $filliable=['AlimentoId','ProveedorId','AlimentoPorProveedorCosto','AlimentoPorProveedorCantidad','AlimentoPorProveedorCantidadUsada','AlimentoPorProveedorVencimiento','AlimentoPorProveedorEstado','AlimentoPorProveedorFechaEntrada','AlimentoPorProveedorCostoTotal'];
}