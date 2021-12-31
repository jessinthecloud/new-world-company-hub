
    </div>

    {{-- additional footer content --}}
    {!! $slot ?? '' !!}
    
    {{--  Javascript  --}}
    @stack('scripts')
    
    @livewireScripts

</body>

</html>