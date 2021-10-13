<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Congelador extends Model
{
    protected $table = 'congelador';
	protected $primaryKey = 'CongeladorId';
	public $timestamps = false;
	protected $filliable=['ComidaId','Porciones'];
}
