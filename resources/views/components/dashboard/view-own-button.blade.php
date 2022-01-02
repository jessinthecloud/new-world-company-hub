@props(['class', 'route', 'company'])

@can('view', $company)
    <x-button-link href="{{ $route }}">
        View My Company
    </x-button-link>
@endcan