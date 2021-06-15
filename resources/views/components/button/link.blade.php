<button
	{{ $attributes->merge([
		'type' => 'button',
		'class' => '
			text-gray-600
			text-sm
			leading-5
			font-medium
			focus:outline-none
			focus:text-blue-600
			focus:underline
			hover:text-blue-600
			transition
			duration-150
			ease-in-out'
			.($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : ''),
	]) }}
	>
	{{ $slot }}
</button>