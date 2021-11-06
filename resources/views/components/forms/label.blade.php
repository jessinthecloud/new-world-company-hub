@props(['value', 'required'=>false])

@php
    $classes = 'mb-1 font-medium text-sm text-gray-700';
    // block class needs to be overrideable for checkbox inputs
    $classes .= ($attributes->get('class') !== null 
                && str_contains($attributes->get('class'), 'inline-block'))
        ? '' : ' block';
@endphp

<label {{ $attributes->merge(['class' => $classes]) }}>
    {{ $value ?? $slot }} {!! $required ? '<span class="required">*</span>' : '' !!}
</label>
