@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge([
        'class' => '
                border-gray-300 
                bg-white 
                text-gray-700 
                focus:border-pink-500 
                focus:ring-pink-200 
                rounded-md 
                shadow-sm
            ',
    ]) }}>
