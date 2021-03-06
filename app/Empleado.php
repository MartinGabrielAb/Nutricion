<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
	protected $table = 'empleado';
	protected $primaryKey = 'EmpleadoId';
	public $timestamps = false;
	protected $filliable=['EmpleadoId','EmpleadoNombre','EmpleadoApellido','EmpleadoDireccion','EmpleadoEmail','EmpleadoTelefono','EmpleadoCuil','EmpleadoEstado'];

}
