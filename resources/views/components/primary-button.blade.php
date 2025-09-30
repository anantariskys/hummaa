@props([
    'px' => 'px-4',
    'py' => 'py-3',
    'rounded' => 'rounded-lg',
    'uc' => 'uppercase',
    'tracking' => 'tracking-widest',
    'width' => 'w-full',
    

])

@php
    $baseClasses = 'inline-flex items-center justify-center bg-main-blue-button border border-transparent font-semibold text-sm text-white hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150';
@endphp

<button {{ $attributes->merge(['type' => 'submit', 'class' => $baseClasses . ' ' . $px . ' ' . $py . ' ' . $rounded . ' ' . $uc . ' ' . $tracking . ' ' . $width]) }}>
    {{ $slot }}
</button>
