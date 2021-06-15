<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Productos extends Model
{
    use HasFactory;

    protected $fillable = [
		'id_categoria',
		'sku',
		'nombre',
		'descripcion',
		'precio',
		'descuento',
		'stock',
		'has_stock',
		'status',
	];

	public function categoria()
    {
        return $this->hasOne('App\Models\Categorias', 'id',  'id_categoria');
	}

	public function imagenes(){
		return $this->morphMany(Imagenes::class, 'relation')->orderBy('id');
	}

    public function scopeActivas(){
		return $query->where('status', 1);
	}

    public function delete()
	{
		$imagenesFromDelete = [];
		foreach ($this->imagenes()->get() as $key => $imagen) {
			array_push($imagenesFromDelete, $imagen->src);
		}
		Storage::disk('public')->delete($imagenesFromDelete);
		$this->imagenes()->delete();
		parent::delete();
	}

    public function deleteImagenes()
	{
		$imagenesFromDelete = [];
		foreach ($this->imagenes()->get() as $key => $imagen) {
			array_push($imagenesFromDelete, $imagen->src);
		}
		Storage::disk('public')->delete($imagenesFromDelete);
		$this->imagenes()->delete();
	}

}
