@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-pink-400 text-start text-base font-medium text-gray-700 bg-pink-50 focus:outline-none focus:text-pink-800 focus:bg-pink-100 focus:border-pink-700 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-pink-600 hover:bg-gray-50 hover:border-pink-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-pink-300 transition duration-150 ease-in-out';
@endphp


<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
