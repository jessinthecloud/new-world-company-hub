@props(['disabled' => false, 'required'=>false, 'autofocus'=>false, 'checked'=>false])

<x-forms.label 
    class="{{ $attributes->only('class')->merge(['class'=>'inline-block']) }}"
    for="{{ $attributes->get('for') }}"
>
    <input
        class="mr-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        
        {{ $disabled ? 'disabled' : '' }}
        {{ $required ? 'required aria-required="true"' : '' }}
        {{ $autofocus ? 'autofocus' : '' }}
        {{ $checked ? 'checked' : '' }}

        {!! $attributes->except(['for', 'class'])->merge(['type'=>'checkbox', 'value'=>1]) !!}
    >
    <span class="label-text">
        {{ $slot }} {!! $required ? '<span class="required">*</span>' : '' !!}
    </span>
</x-forms.label>