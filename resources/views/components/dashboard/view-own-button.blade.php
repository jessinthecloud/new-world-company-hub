@props(['class', 'route', 'instance'])

@can('view', $instance)
    <x-button-link href="{{ $route }}">
        {{ empty($slot->toHtml()) ? 'View' : $slot}}
    </x-button-link>
@endcan