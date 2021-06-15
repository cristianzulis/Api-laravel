<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagenes extends Model
{
    use HasFactory;

    protected $fillable = [
		'id',
		'src',
		'relation_id',
		'relation_type',
	];

	public function relation()
    {
        return $this->morphTo();
	}

}
