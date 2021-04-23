<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
	protected $primaryKey = 'id';
	protected $filliable=['name','guard_name','created_at','updated_at'];
	
}
