<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    use HasFactory;

    protected $fillable = [
		'id_padre',
		'codigo',
		'nombre',
		'subnivel'
	];

	public function padre()
    {
        return $this->hasOne('App\Models\Categorias', 'id',  'id_padre');
	}

	public function scopeSubniveles($query)
	{
		return $query->where('subnivel', 0)->select(['id', 'nombre']);
	}
}
