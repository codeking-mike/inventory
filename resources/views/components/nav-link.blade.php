@props(['active', 'href'])

@php
$classes = ($active ?? false)
            ? 'bg-blue-50 text-blue-700 group flex items-center px-3 py-2 text-sm font-medium rounded-md border-r-4 border-blue-600'
            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>