<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'role_has_permissions';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $filliable=['permission_id','role_id'];
}