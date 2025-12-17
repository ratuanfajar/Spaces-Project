@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'block w-full border-0 border-b-2 border-slate-200 bg-transparent py-2.5 text-slate-900 placeholder:text-slate-400 focus:border-slate-800 focus:ring-0 sm:text-sm sm:leading-6 transition-colors duration-300 ease-in-out'
]) !!}>