
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
        
        function getName(item){
            return item.name;
        }
        
        async function getWeapon(slug) {
console.log('fetching: '+slug);        
            let response = await fetch('/base-weapons/'+slug);
            const weapon = await response.json();
            let perks = weapon.data.perks;
            let perkNames = [...new Set(perks.map(getName))];
            // let perkName = (perks, name) => perks.map(x=>x[name]);
console.log('weapon response:',weapon.data, 'perks:',perks, 'perk names:',perkNames);
            
            return perkNames.join(', ');
        }
    </script>

</body>

</html>