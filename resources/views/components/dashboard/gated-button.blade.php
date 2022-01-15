@props(['class', 'route', 'can', 'instance'=>null])

@can($can, $instance)
    <x-button-link href="{{ $route }}">
        {{ empty($slot->toHtml()) ? 'View' : $slot}}
    </x-button-link>
@endcan