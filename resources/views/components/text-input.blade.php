@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'block w-full border-0 border-b-2 border-gray-300 bg-transparent py-2.5 text-gray-900 focus:border-slate-800 focus:ring-0 placeholder:text-gray-400 sm:text-sm sm:leading-6 transition-colors duration-200'
]) !!}>