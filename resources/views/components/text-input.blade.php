@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' =>
'border-gray-300 focus:border-main-bg focus:ring-main-bg rounded-md shadow-sm']) !!}>
