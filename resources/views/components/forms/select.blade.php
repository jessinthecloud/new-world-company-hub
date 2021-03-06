@props(['values', 'disabled' => false, 'required'=>false, 'autofocus'=>false, 'multiple'=>false, 'index'=>null])

<select
        {!! $attributes
            ->class(['rounded-md shadow-sm border-gray-300 pr-8 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50',
            // only include this class if there is an error
            'has-error' => ($errors->has($attributes->get('name')) 
                || $errors->has(Str::beforeLast($attributes->get('name'), '[')))
        ])->merge() !!}
        {{ $disabled ? ' disabled' : '' }}
        {{ $required ? ' aria-required="true"' : '' }}
        {{ $autofocus ? ' autofocus' : '' }}
        {{ $multiple ? ' multiple' : '' }}
>
    {{ $slot ?? '' }}

    @isset($values)
        @php
            // array fields names are shown as "rarity[main]"
            $index = Str::between($attributes->get('name'), '[', ']');
            $name = Str::before($attributes->get('name'), '[');
        @endphp
        <option value=""></option>
        @foreach($values as $value => $text)
            <option value="{{ $value ?? '' }}"
                @if(old($attributes->get('name')) == $value 
                    || (
                        array_key_exists($name, old())
                        && isset(old($name)[$index]) 
                        && old($name)[$index] == $value
                    )
                )
                    SELECTED
                @endif
            >
                {{ $text }}
            </option>
        @endforeach
    @endisset
</select>