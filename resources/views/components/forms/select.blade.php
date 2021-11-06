@props(['values', 'disabled' => false, 'required'=>false, 'autofocus'=>false])

<select
    {!! $attributes->merge([
        'class' => 'rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50'
    ]) !!}
    {{ $disabled ? 'disabled' : '' }}
    {{ $required ? 'required aria-required="true"' : '' }}
    {{ $autofocus ? 'autofocus' : '' }} 
>
    {{ $slot ?? '' }}

    @foreach($values as $text => $value)
        <option value="{{ $value ?? '' }}"
            @if(old($attributes->get('name')) == $value)
                SELECTED
            @endif
        >
            {{ $text }}
        </option>
    @endforeach
</select>