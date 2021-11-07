@props(['instructions', 'disabled' => false, 'required'=>false])

<input 
    {{ $disabled ? 'disabled' : '' }}
    {{ $required ? 'aria-required="true"' : '' }}
    {!! $attributes
        ->class([
            'rounded-md shadow-sm border-gray-300 
            focus:border-indigo-300 
            focus:ring 
            focus:ring-indigo-200 
            focus:ring-opacity-50',
            // only include this class if there is an error
            'has-error' => $errors->has($attributes->get('name'))
        ])
        ->merge([
            'type' => 'text',
            'size' => '30',
        ]) 
    !!}
/>
