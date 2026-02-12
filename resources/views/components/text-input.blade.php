@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} 
    {!! $attributes->merge([
        'class' => 'border-blue-300 bg-white text-blue-900 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm disabled:bg-blue-50 disabled:text-blue-400 disabled:cursor-not-allowed'
    ]) !!}>
