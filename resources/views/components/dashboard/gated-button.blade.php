@props(['phpClass', 'route', 'can', 'instance'=>null])

@can(...$can)
    <x-button-link href="{{ $route }}" 
        {{ $attributes->merge([
            'class' => 'mr-1 mb-2'
        ]) }}
    >
        {{ empty($slot->toHtml()) ? 'View' : $slot}}
    </x-button-link> 
@endcan