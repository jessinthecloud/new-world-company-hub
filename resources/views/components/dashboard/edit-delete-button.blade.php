@props(['class', 'route', 'instance'])

@can('update', $instance)
    <x-button-link href="{{ $route }}">
        {{ empty($slot->toHtml()) ? 'Edit / Delete' : $slot}}
    </x-button-link>
@endif