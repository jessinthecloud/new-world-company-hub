@props(['value', 'disabled' => false, 'required'=>false, 'autofocus'=>false])

<textarea
    {!! $attributes->merge([
        'class' => 'rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50'
    ]) !!}
    {{ $disabled ? 'disabled' : '' }}
    {{ $required ? 'required aria-required="true"' : '' }}
    {{ $autofocus ? 'autofocus' : '' }}
>{!! $value ?? $attributes->get('value') ?? '' !!}</textarea>
