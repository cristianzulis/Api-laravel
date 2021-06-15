<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
//MODELS
use App\Models\Categorias;

class ModuloCategorias extends Component
{

	use WithPagination;

	public $search;
	public $perPage = '5';
	public $ifOpenModalCategorias = false;
	public $ifOpenDeleteCategorias = false;
	public $categoriasInput = Categorias::class;
	public $create = true; // edit = false

	protected $rules = [
		'categoriasInput.id_padre'=>'nullable|exists:categorias,id',
		'categoriasInput.nombre' => 'required|max:200',
	];
	protected $messages = [
		'id.exists' => 'El id debe existir en la tabla de categorias.',
		'required' => 'El campo :attribute es requerido.',
		'numeric' => 'El campo :attribute debe ser un numero',
		'unique' => 'El :attribute :input ya existe en la tabla de categorias.',
		'max' => 'El :attribute no debe tener más de :max caracteres.'
	];

    public function render()
    {
		$categorias = Categorias::where('nombre', 'like', "%{$this->search}%")
		->orWhereHas('padre', function($q){
			$q->where('nombre', 'like', "%{$this->search}%");
		});
        return view('livewire.categorias.categoriasView', [
			'categorias' => $categorias->paginate($this->perPage),
			'padres' => Categorias::get()
		]);
	}

	public function createCategoria()
	{
		$this->validate();

		Categorias::create($this->categoriasInput);
		if(array_key_exists('id_padre', $this->categoriasInput)){
			$padre = Categorias::whereId($this->categoriasInput['id_padre'])->first();
			$padre->subnivel = 1;
			$padre->save();
		}
		$this->ifOpenModalCategorias = false;
		$this->reset('categoriasInput');
		$this->notify('Categoria creada con exito');
	}

	public function updateCategoria()
	{
		$this->validate();
		$categoria = Categorias::whereId($this->categoriasInput->id)->first();
		if($categoria->id_padre && !$this->categoriasInput->id_padre){
			$count = count(Categorias::whereIdPadre($categoria->id_padre)->get());
			if($count == 1){
				$padre = Categorias::whereId($categoria->id_padre)->first();
				$padre->subnivel = 0;
				$padre->save();
			}
		}else if($this->categoriasInput->id_padre){
			$padre = Categorias::whereId($this->categoriasInput->id_padre)->first();
			$padre->subnivel = 1;
			$padre->save();
		}
		$this->categoriasInput->save();
		$this->ifOpenModalCategorias = false;
		$this->reset('categoriasInput');
		$this->notify('Categoria actualizada con exito');
	}

	public function deleteCategoria()
	{
		$categoria = Categorias::whereId($this->categoriasInput['id'])->first();
		if($categoria->id_padre && !property_exists('id_padre', $this->categoriasInput)){
			$padre = Categorias::whereIdPadre($this->categoriasInput['id_padre'])->get();
			if(count($padre) == 1){
				$padre = Categorias::whereId($categoria->id_padre)->first();
				$padre->subnivel = 0;
				$padre->save();
			}
		}
		$this->categoriasInput->delete();
		$this->ifOpenDeleteCategorias = false;
		$this->reset('categoriasInput');
		$this->notify('Categoria eliminada con exito');
	}

	public function showCreateCategoria()
	{
		$this->ifOpenModalCategorias = true;
		$this->reset('categoriasInput');
		$this->create = true;
	}

	public function showEditCategoria(Categorias $categoria)
    {
		$this->ifOpenModalCategorias = true;
		$this->categoriasInput = $categoria;
		$this->create = false;
	}

	public function showDeleteCategoria(Categorias $categoria)
	{
		$this->categoriasInput = $categoria;
		$this->ifOpenDeleteCategorias = true;
	}

	public function closeModalsCategoria()
	{
		$this->ifOpenModalCategorias = false;
		$this->ifOpenDeleteCategorias = false;
	}

}
