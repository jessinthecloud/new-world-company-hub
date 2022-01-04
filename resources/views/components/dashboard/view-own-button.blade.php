@props(['class', 'route', 'instance'])

@can('view', $instance)
    <x-button-link href="{{ $route }}">
        View
    </x-button-link>
@endcan