
    </div>

    {{-- additional footer content --}}
    {!! $slot ?? '' !!}
    
    {{--  Javascript  --}}
    @stack('scripts')
    
    @livewireScripts

    <script>
        $(document).ready(function() {
        
            $('.add-attr').click(function () {
                // add another attr field set
                
                let clone = $(this).siblings('.attr-wrapper').clone();
                // reset attr amount
                $(clone).find('input').val('');
                $(this).siblings('.appended-attrs').append(clone);
            });
            
            $('.add-perk').click(function () {
                // add another perk field set
                $(this).siblings('.appended-perks').append($(this).siblings('.perks-wrapper').clone());
            });
        });

                    function getName(item){
                        return item.name;
                    }
                    
                    async function getItems(type) {
            
            // console.log('fetching all: ' + type);
            
                        let response = await fetch('/' + type);
                        let json = await response.json();
            // console.log('response: ',json);
                        return await json;
                    }
                    
                    async function getItem(type, slug) {
                    
            // console.log('fetching: '+type+': '+slug);        
                        
                        let response = await fetch('/'+type+'/'+slug);
            // console.log('response: '+response);            
                        return response.html();
            }
    </script>

</body>

</html>