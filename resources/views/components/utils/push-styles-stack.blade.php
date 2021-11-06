@props(['styles'])

{{-- Styles passed in --}}
@foreach($styles as $style)
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/'.$style) }}">
    @endpush
@endforeach