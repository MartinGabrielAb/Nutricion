<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
   	protected $table = 'proveedor';
	protected $primaryKey = 'ProveedorId';
	public $timestamps = false;
	protected $filliable=['ProveedorNombre','ProveedorTelefono','ProveedorDireccion','ProveedorEmail','ProveedorCuit','ProveedorEstado'];
}