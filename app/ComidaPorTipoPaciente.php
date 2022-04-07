<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComidaPorTipoPaciente extends Model
{
    protected $table = 'comidaportipopaciente';
	protected $primaryKey = 'ComidaPorTipoPacienteId';
	public $timestamps = false;
	protected $filliable=['DetalleMenuTipoPacienteId','ComidaId','TipoComidaId','Variante'];
}