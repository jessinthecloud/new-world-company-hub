
    </div>

    {{-- additional footer content --}}
    {!! $slot ?? '' !!}
    
    {{--  Javascript  --}}
    @stack('scripts')
    
    @livewireScripts
    
    <script>
        $(document).ready(function(){
            $('#add-attr').click(function(){
                $('#appended-attrs').append($('#attr-sample').clone());
            });
            $('#add-perk').click(function(){
                $('#appended-perks').append($('#perk-sample').clone());
            });
            
            $('#add-armor').click(function(){
                $(this).parent().hide();
                $('#armor-field').removeClass('hidden');
                $('#name-field').removeClass('hidden');
            });
            
            $('#add-weapon').click(function(){
                $(this).parent().hide();
                $('#weapon-field').removeClass('hidden');
                $('#name-field').removeClass('hidden');
            });
        });
        
        async function getWeapon(weapon) {
            let response = await fetch('/weapons/'+weapon);
console.log('response:',response);         
            return await response.text();
        }
    </script>

</body>

</html>