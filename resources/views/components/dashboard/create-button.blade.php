@props(['class', 'route'])

@can('create', $class)
    <x-button-link href="{{ $route }}">
        Create
    </x-button-link>
@endif