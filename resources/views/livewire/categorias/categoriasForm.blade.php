<x-jet-dialog-modal wire:model="ifOpenModalCategorias">

	<x-slot name="title">
		@if ($create)
			Crear categoria
		@else
			Editar categoria
		@endif
	</x-slot>


	<x-slot name="content">

			<div>
				<x-jet-label for="padre" value="{{ __('Padre') }}" />
				<select wire:model="categoriasInput.id_padre" id="id_padre" name="id_padre" class="mt-1 block border border-gray-300 bg-white rounded-md text-gray-500 w-full">
					<option value="">Seleccionar</option>
					@foreach($padres as $padre)
						<option value="{{ $padre->id }}">{{ $padre->nombre }}</option>
					@endforeach
				</select>
				@error('categoriasInput.id_padre') <span class="error text-red-600">{{ $message }}</span> @enderror
			</div>

			<div class="mt-4">
				<x-jet-label for="nombre" value="{{ __('Nombre') }}" />
				<x-jet-input wire:model="categoriasInput.nombre" id="nombre" name="nombre" class="block text-gray-500 mt-1 w-full" type="text" />
				@error('categoriasInput.nombre') <span class="error text-red-600">{{ $message }}</span> @enderror
			</div>

	</x-slot>

	<x-slot name="footer">

		<x-jet-danger-button wire:click="closeModalsCategoria">
			{{ __('Cancelar') }}
		</x-jet-danger-button>

		<x-button.primary wire:click='createCategoria' class="ml-4" wire:loading.attr="disabled" hidden="{{!$create}}">
			{{ __('Crear Categoria') }}
		</x-button.primary>

		<x-button.primary wire:click='updateCategoria' class="ml-4" wire:loading.attr="disabled" hidden="{{$create}}">
			{{ __('Editar Categoria') }}
		</x-button.primary>

	</x-slot>

</x-jet-dialog-modal>
