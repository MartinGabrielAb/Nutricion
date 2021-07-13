<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelevamientoPorSala extends Model
{
    protected $table = 'relevamientoporsala';
    protected $primaryKey = 'RelevamientoPorSalaId';
    protected $filliable=['RelevamientoId','SalaId','RelevamientoPorSalaAcompaniantes','RelevamientoPorSalaEstado'];

    public $timestamps = false;
}
