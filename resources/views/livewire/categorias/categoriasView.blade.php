<div>
	{{-- BOTON CREAR CATEGORIAS --}}

	<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-2">
		<x-jet-button wire:click="showCreateCategoria">
			{{ __('Crear categoria') }}
		</x-jet-button>
	</div>

	<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
		<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

			{{-- TABLA CATEGORIAS --}}
			<div class="flex flex-col">
				<div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
					<div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
						<div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">

							<div class="flex bg-white px-4 py-3 border-t border-gray-200 sm:px-6">

								<div >
									<select class="mt-1 block border border-gray-300 bg-white rounded-md text-gray-500 mr-6 text-sm"
										wire:model="perPage"
									>
										<option value="5">5 por página</option>
										<option value="10">10 por página</option>
										<option value="15">15 por página</option>
										<option value="25">25 por página</option>
										<option value="50">50 por página</option>
									</select>
								</div>

								<x-jet-input class="form-input rounded-md block mt-1 w-full text-sm" type="text" placeholder="Buscar..."
									wire:model="search"
								/>

							</div>

							<table class="min-w-full divide-y divide-gray-200">
								<thead class="bg-gray-50">
									<tr>
										<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
										Nombre
										</th>
										<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
										Padre
										</th>
										<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
										SubNivel
										</th>
										<th scope="col" class="relative px-6 py-3">
											<span class="sr-only">Edit</span>
										</th>
									</tr>
								</thead>
								<tbody class="bg-white divide-y divide-gray-200">

									@foreach ($categorias as $categoria)
										<tr>
											<td class="px-6 py-3 ">
											<div class="text-sm text-gray-900">{{ $categoria->nombre }}</div>
											</td>
											<td class="px-6 py-3">
												@if ($categoria->padre)
													<div class="text-sm text-gray-900">{{ $categoria->padre->nombre }}</div>
												@endif
											</td>
											<td class="px-6 py-3">
												@if (!$categoria->subnivel)
													<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
														Si
													</span>
												@else
												@endif

											</td>
											<td class="px-6 py-3 text-sm font-medium">
												<x-button.link wire:click="showEditCategoria({{ $categoria->id }})">
													Editar
												</x-button.link>
												<x-button.link wire:click="showDeleteCategoria({{ $categoria->id }})" class="text-red-500 ml-3">
													Eliminar
												</x-button.link>
											</td>
										</tr>
									@endforeach

								</tbody>
							</table>

							@if ($categorias->count())
								<div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
									{{ $categorias->links() }}
								</div>
							@else
								<div class="bg-white px-4 py-3 border-t border-gray-200 text-gray-500 sm:px-6">
									No hay resultados para la busqueda "{{ $search }}"
								</div>
							@endif

						</div>
					</div>
				</div>
			</div>

			{{-- FORMULARIO CATEGORIAS --}}
			@include('livewire.categorias.categoriasForm')

			{{-- MODAL DELETE CATEGORIAS --}}
			<x-modal.confirmation wire:model="ifOpenDeleteCategorias" maxWidth="sm" class="h-5/6">

				<x-slot name="title">
					¿Desea eliminar la categoria?
				</x-slot>

				<x-slot name="content">
					Este proceso no se podrá revertir!
				</x-slot>

				<x-slot name="footer">

					<x-button.danger wire:click="closeModalsCategoria">
						{{ __('Cancelar') }}
					</x-button.danger>

					<x-button.primary wire:click='deleteCategoria' class="ml-4" wire:loading.attr="disabled">
						{{ __('Borrar Categoria') }}
					</x-button.primary>

				</x-slot>

			</x-modal.confirmation>

		</div>
	</div>
</div>
