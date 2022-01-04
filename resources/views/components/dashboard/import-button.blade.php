@props(['class', 'route'])

@can('import', $class)
    <x-button-link href="{{ $route }}">
        Import
    </x-button-link>
@endif