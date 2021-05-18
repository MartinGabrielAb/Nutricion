<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelevamientoComida extends Model
{
    protected $table = 'relevamientocomida';
    protected $primaryKey = 'RelevamientoComidaId';
    protected $filliable=['RelevamientoId','ComidaId','RelevamientoComidaCantidad'];

    public $timestamps = false;
}
