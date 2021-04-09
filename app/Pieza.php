<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pieza extends Model
{
    protected $table = 'pieza';
	protected $primaryKey = 'PiezaId';
	protected $filliable=['PiezaNombre','PiezaEstado','SalaId'];
	public $timestamps = false;
}
