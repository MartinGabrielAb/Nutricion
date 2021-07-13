<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relevamiento extends Model
{
    protected $table = 'relevamiento';
    protected $primaryKey = 'RelevamientoId';
    protected $filliable=['EmpleadoId','RelevamientoFecha','RelevamientoEstado','RelevamientoTurno','RelevamientoControlado'];

    public $timestamps = false;
}