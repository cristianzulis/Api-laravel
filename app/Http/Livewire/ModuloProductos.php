<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
//MODELS
use App\Models\Productos;
use App\Models\Categorias;
use App\Models\Imagenes;

class ModuloProductos extends Component
{

	use WithPagination;
	use WithFileUploads;

	public $photos = [];
	public $search;
	public $perPage = '5';
	public $ifOpenModalProductos = false;
	public $ifOpenDeleteProductos = false;
	public $create = true; // edit = false
    public $productosInput = Productos::class;

	protected $rules = [
		'productosInput.id_categoria'=>'required|exists:categorias,id',
		'productosInput.sku' => 'nullable|min:1|max:100',
		'productosInput.nombre' => 'required|min:3|max:100',
		'productosInput.descripcion' => 'nullable|min:1|max:255',
		'productosInput.precio' => 'required|numeric',
		'productosInput.descuento' => 'nullable|numeric|max:100',
		'productosInput.stock' => 'nullable|numeric',
		'productosInput.has_stock' => 'nullable|boolean',
		'productosInput.status' => 'nullable|boolean',
	];
	protected $messages = [
		'id.exists' => 'El id debe existir en la tabla de categorias.',
		'required' => 'El campo :attribute es requerido.',
		'numeric' => 'El campo :attribute debe ser un numero',
		'unique' => 'El :attribute :input ya existe en la tabla de categorias.',
		'max' => 'El :attribute no debe se mayor que :max.',
		'size' => 'El :attribute no debe se más de :size caracteres.'
	];

	public function render()
	{
		$productos = Productos::where('nombre', 'like', "%{$this->search}%")
		->orWhereHas('categoria', function($q){
			$q->where('nombre', 'like', "%{$this->search}%");
		});

		$productos->with('imagenes');
		return view('livewire.productos.productosView', [
			'productos' => $productos->paginate($this->perPage),
			'categorias' => Categorias::Subniveles()->get(),
		]);
	}

	public function createProducto()
	{
		$this->validate();
		$producto = Productos::create($this->productosInput);
		if(count($this->photos)>0){
			$imagenes = $this->uploadImages();
			$producto->imagenes()->saveMany($imagenes);
		}
		$this->ifOpenModalProductos = false;
		$this->reset('productosInput');
		$this->notify('Producto creado con exito');
	}

	public function updateProducto()
	{
		$this->validate();
		$this->productosInput->save();
		if(count($this->photos)>0){
			$producto = Productos::find($this->productosInput->id);
			$producto->deleteImagenes();
			$imagenes = $this->uploadImages();
			$producto->imagenes()->saveMany($imagenes);
		}
		$this->ifOpenModalProductos = false;
		$this->reset('productosInput');
		$this->notify('Producto actualizado con exito');
	}

	public function deleteProducto()
	{
		$this->productosInput->delete();
		$this->ifOpenDeleteProductos = false;
		$this->reset('productosInput');
		$this->notify('Producto eliminado con exito');
	}

	public function uploadImages()
	{
		$imagenesToInsert = [];
		foreach ($this->photos as $key => $photo) {
			$src = $photo->store('productos','public');
			$imagenesToInsert[] = new Imagenes(['src' => $src]);
		}
		return $imagenesToInsert;
	}

	public function showCreateProducto()
	{
		$this->ifOpenModalProductos = true;
		$this->reset('productosInput');
		$this->create = true;
		$this->photos = [];
	}

	public function showEditProducto(Productos $producto)
    {
		$this->ifOpenModalProductos = true;
		$this->productosInput = $producto;
		$this->create = false;
		$this->photos = [];
	}

	public function showDeleteProducto(Productos $producto)
	{
		$this->productosInput = $producto;
		$this->ifOpenDeleteProductos = true;
	}

	public function closeModalsProducto()
	{
		$this->ifOpenModalProductos = false;
		$this->ifOpenDeleteProductos = false;
	}

}
