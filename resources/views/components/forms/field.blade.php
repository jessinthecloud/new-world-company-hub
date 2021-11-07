@props(['instructions', 'name', 'required'=>false, ])

<div {!! $attributes->merge(['class' => 'field']) !!}>
    {{-- form inputs passed through --}}
    {!! $slot !!}

    @isset($instructions)
        <div class="field-inst">{{ $instructions }}</div>
    @endisset

    @if($errors->has($name))
        <x-forms.input-error :message="$errors->get($name)" />
    @endif
</div>