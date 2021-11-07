@props(['scripts'])

{{-- Styles passed in --}}
@foreach($scripts as $script)
    @push('scripts')
        <script src="{{ asset('js/'.$script) }}"></script>
    @endpush
@endforeach