<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    protected $table = 'sala';
	protected $primaryKey = 'SalaId';
	protected $filliable=['SalaNombre','SalaEstado'];
	public $timestamps = false;
}
