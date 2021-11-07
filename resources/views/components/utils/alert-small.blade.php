@props(['message', 'type'=>'danger'])

<div
    {!! $attributes->merge(['class'=>'alert alert-sm alert-'.$type.' p-2']) !!}
>
    {{ $message }}
</div>