@props(['route', 'can', 'routeName'=>null])
{{-- allow not set for backward compat --}}
@if(!isset($routeName) || Route::has($routeName))
    @can(...$can)
        <x-button-link href="{{ $route }}" 
            {{ $attributes->merge([
                'class' => 'mr-1 mb-2'
            ]) }}
        >
            {{ empty($slot->toHtml()) ? 'View' : $slot }}
        </x-button-link> 
    @endcan
@endif