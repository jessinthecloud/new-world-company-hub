@props(['class', 'route', 'instance'])

@can('update', $instance)
    <x-button-link href="{{ $route }}">
        Edit / Delete
    </x-button-link>
@endif