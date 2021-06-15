<x-jet-dialog-modal wire:model="ifOpenModalProductos">

	<x-slot name="title">
		@if ($create)
			Crear producto
		@else
			Editar producto
		@endif
	</x-slot>


	<x-slot name="content">

		<div class="grid grid-cols-2">
			<div>
				<x-jet-label for="sku" value="{{ __('Sku') }}" />
				<x-jet-input wire:model="productosInput.sku" id="sku" name="sku" class="block text-gray-500 mt-1 w-11/12" type="text" />
				@error('productosInput.sku') <span class="error text-red-600">{{ $message }}</span> @enderror
			</div>

			<div class="">
				<x-jet-label for="categoria" value="{{ __('Categoria') }}" />
				<select wire:model="productosInput.id_categoria" id="id_categoria" name="id_categoria" class="mt-1 block border border-gray-300 bg-white rounded-md text-gray-500 w-11/12">
					<option value="">Seleccionar</option>
					@foreach($categorias as $categoria)
						<option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
					@endforeach
				</select>
				@error('productosInput.id_categoria') <span class="error text-red-600">{{ $message }}</span> @enderror
			</div>

			<div class="mt-4">
				<x-jet-label for="nombre" value="{{ __('Nombre') }}" />
				<x-jet-input wire:model="productosInput.nombre" id="nombre" name="nombre" class="block text-gray-500 mt-1 w-11/12" type="text" />
				@error('productosInput.nombre') <span class="error text-red-600">{{ $message }}</span> @enderror
			</div>

			<div class="mt-4">
				<x-jet-label for="precio" value="{{ __('Precio') }}" />
				<x-jet-input wire:model="productosInput.precio" id="precio" name="precio" class="block text-gray-500 mt-1 w-11/12" type="text" />
				@error('productosInput.precio') <span class="error text-red-600">{{ $message }}</span> @enderror
			</div>

			<div class="mt-4">
				<x-jet-label for="descuento" value="{{ __('Descuento') }}" />
				<x-jet-input wire:model="productosInput.descuento" id="descuento" name="descuento" class="block text-gray-500 mt-1 w-11/12" type="text" />
				@error('productosInput.descuento') <span class="error text-red-600">{{ $message }}</span> @enderror
			</div>

			<div class="mt-4">
				<x-jet-label for="has_stock" value="{{ __('Tiene stock') }}" />
				<select wire:model="productosInput.has_stock" id="has_stock" name="has_stock" class="mt-1 block border border-gray-300 bg-white rounded-md text-gray-500 w-11/12">
					<option value="0">No</option>
					<option value="1">Si</option>
				</select>
				@error('productosInput.has_stock') <span class="error text-red-600">{{ $message }}</span> @enderror
			</div>

			<div class="mt-4">
				<x-jet-label for="stock" value="{{ __('Stock') }}" />
				<x-jet-input wire:model="productosInput.stock" id="stock" name="stock" class="block text-gray-500 mt-1 w-11/12" type="text" />
				@error('productosInput.stock') <span class="error text-red-600">{{ $message }}</span> @enderror
			</div>

			<div class="mt-4">
				<x-jet-label for="status" value="{{ __('Estado') }}" />
				<select wire:model="productosInput.status" id="status" name="status" class="mt-1 block border border-gray-300 bg-white rounded-md text-gray-500 w-11/12">
					<option value="1">Activo</option>
					<option value="0">Inactivo</option>
				</select>
				@error('productosInput.status') <span class="error text-red-600">{{ $message }}</span> @enderror
			</div>

			<div class="mt-4" x-data="{ isUploading: false, progress: 0 }"
			x-on:livewire-upload-start="isUploading = true"
			x-on:livewire-upload-finish="isUploading = false"
			x-on:livewire-upload-error="isUploading = false"
			x-on:livewire-upload-progress="progress = $event.detail.progress">
				<x-jet-label for="fotos" value="{{ __('Fotos') }}" />
				<input type="file" wire:model="photos" multiple>
				{{-- @error('productosInput.stock') <span class="error text-red-600">{{ $message }}</span> @enderror --}}
				<div x-show="isUploading">
					<progress max="100" x-bind:value="progress"></progress>
				</div>
			</div>


			<div class="flex mt-4">
				@foreach ($photos as $photo)
				<div>
					<img src="{{ $photo->temporaryUrl() }}" class="w-20 mr-10">
				</div>
				@endforeach
			</div>
		</div>

	</x-slot>

	<x-slot name="footer">

		<x-jet-danger-button wire:click="closeModalsProducto">
			{{ __('Cancelar') }}
		</x-jet-danger-button>

		<x-button.primary wire:click='createProducto' class="ml-4" wire:loading.attr="disabled" hidden="{{!$create}}">
			{{ __('Crear Producto') }}
		</x-button.primary>

		<x-button.primary wire:click='updateProducto' class="ml-4" wire:loading.attr="disabled" hidden="{{$create}}">
			{{ __('Editar Producto') }}
		</x-button.primary>

	</x-slot>

</x-jet-dialog-modal>
