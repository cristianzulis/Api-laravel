<div>
	{{-- BOTON CREAR PRODUCTOS --}}

	<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-2">
		<x-jet-button wire:click="showCreateProducto">
			{{ __('Crear producto') }}
		</x-jet-button>
	</div>

	<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
		<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

			{{-- TABLA PRODUCTO --}}
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
											Categoria
										</th>
										<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
											Precio
										</th>
										<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
											Stock
										</th>
										<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
											Estado
										</th>
										<th scope="col" class="relative px-5 py-3">
											<span class="sr-only">Edit</span>
										</th>
									</tr>
								</thead>
								<tbody class="bg-white divide-y divide-gray-200">

									@foreach ($productos as $producto)
										<tr>
											<td class="px-6 py-2">
												<div class="flex items-center">
													<div class="flex h-10 w-10 ">
														@if (count($producto->imagenes)>0)
															<img class="h-10" src="{{ url('storage/'.$producto->imagenes[0]->src) }}" alt="{{ $producto->nombre }}">
														@else
															<img class="h-10 w-10 rounded-lg" src="https://ui-avatars.com/api/?name={{ $producto->nombre }}&color=7F9CF5&background=EBF4FF" alt="">
														@endif
													</div>
													<div class="ml-4">
														<div class="text-sm font-medium text-gray-900">
															{{ $producto->nombre }}
														</div>
													</div>
												</div>
											</td>
											<td class="px-6 py-2">
												<div class="text-sm text-gray-900">{{ $producto->categoria->nombre }}</div>
											</td>
											<td class="px-6 py-2 ">
												<div class="text-sm text-gray-900">
													{{ $producto->precio }}
												</div>
											</td>
											<td class="px-6 py-2 ">
												<div class="text-sm text-gray-900">
													@if ($producto->stock === "0")
														<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
															Agotado
														</span>
													@else
														{{ $producto->stock }}
													@endif
												</div>
											</td>
											<td class="px-6 py-2 ">
												<div class="text-sm text-gray-900">
													@if ($producto->status)
														<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
															Activo
														</span>
													@else
														<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
															Inactivo
														</span>
													@endif
												</div>
											</td>
											<td class="px-6 py-3 text-sm font-medium">
												<x-button.link wire:click="showEditProducto({{ $producto->id }})">
													Editar
												</x-button.link>
												<x-button.link wire:click="showDeleteProducto({{ $producto->id }})" class="text-red-500">
													Eliminar
												</x-button.link>
											</td>
										</tr>
									@endforeach

								</tbody>
							</table>

							@if ($productos->count())
								<div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
									{{ $productos->links() }}
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

			{{-- FORMULARIO PRODUCTOS --}}
			@include('livewire.productos.productosForm')

			{{-- MODAL DELETE CATEGORIAS --}}
			<x-modal.confirmation wire:model="ifOpenDeleteProductos" maxWidth="sm" class="h-5/6">

				<x-slot name="title">
					¿Desea eliminar la producto?
				</x-slot>

				<x-slot name="content">
					Este proceso no se podrá revertir!
				</x-slot>

				<x-slot name="footer">

					<x-button.danger wire:click="closeModalsProducto">
						{{ __('Cancelar') }}
					</x-button.danger>

					<x-button.primary wire:click='deleteProducto' class="ml-4" wire:loading.attr="disabled">
						{{ __('Borrar Producto') }}
					</x-button.primary>

				</x-slot>

			</x-modal.confirmation>

		</div>
	</div>
</div>
