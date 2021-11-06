@props(['message'])

<div
    {!! $attributes->merge(['class'=>'field-error p-1']) !!}
>
    @foreach($message as $msg)
        <span>{{ $msg }}</span>
    @endforeach
</div>