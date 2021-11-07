
    </div>

    {{-- additional footer content --}}
    {!! $slot ?? '' !!}
    
    {{--  Javascript  --}}
    @stack('scripts')

</body>

</html>