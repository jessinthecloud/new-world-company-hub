
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
            
            /*$('#add-armor').click(function(){
                $(this).parent().hide();
                $('#armor-field').removeClass('hidden');
                $('#name-field').removeClass('hidden');
                $('#add-new-entry').removeClass('hidden');
                $('#perks-attr-wrapper').removeClass('hidden');
                $('#submit-button').removeClass('hidden');
            });
            
            $('#add-weapon').click(function(){
                $(this).parent().hide();
                // $('#weapon-field').removeClass('hidden');
                // $('#name-field').removeClass('hidden');
                $('#add-new-entry').removeClass('hidden');
                $('#perks-attr-wrapper').removeClass('hidden');
                $('#submit-button').removeClass('hidden');
            });*/
        });
        
        function getName(item){
            return item.name;
        }
        
        async function getItems(type) {

console.log('fetching all: ' + type);

            let response = await fetch('/' + type);
            let json = await response.json();
console.log('response: ',json);
            return await json;
        }
        
        async function getItem(type, slug) {
        
console.log('fetching: '+type+': '+slug);        
            
            let response = await fetch('/'+type+'/'+slug);
console.log('response: '+response);            
            return response.json();
            
            
            /*let perks = weapon.data.perks;
            let perkNames = [...new Set(perks.map(getName))];
            // let perkName = (perks, name) => perks.map(x=>x[name]);
console.log('weapon response:',weapon.data, 'perks:',perks, 'perk names:',perkNames);
            
            return perkNames.join(', ');*/
        }
    </script>

</body>

</html>