
    </div>

    {{-- additional footer content --}}
    {!! $slot ?? '' !!}
    
    {{--  Javascript  --}}
    @stack('scripts')
    
    @livewireScripts
<style>
        .tooltip {
            background-color: #333;
            border-radius: 5px;
            box-sizing:border-box;
            color: #fff;
            height: auto;
            padding: 1.5em;
            position: absolute;
            top: -15px;
            width: 25em;
        }
        .tooltip-wrapper {
            position:relative;
        }
        .tooltip div {
            position:relative;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('#add-attr').click(function(){
                $('#appended-attrs').append($('#attr-wrapper').clone());
            });
            $('#add-perk').click(function(){
                $('#appended-perks').append($('#perks-wrapper').clone());
            });
                        
            /*$('tr').hover(function(){
                let type = $(this).children('td').first().next().text().toLowerCase().trim();
                let slug = $(this).children('td').last().text().trim();
                var $this = $(this);
                $('.tooltip-wrapper').remove();
                
                if(typeof slug != "undefined" && slug != ''){
                    // go get weapon info
                    // item = getItem(type, slug);
                    // console.log(item);
                    
                    let itemUrl = '/'+type+'s'+'/'+slug+'?popup=1';
console.log($this,type+'s', slug, itemUrl);       
             
                    $.ajax({
                        url: itemUrl,
                        contentType: 'html'
                    })
                    .done(function(data){
                        //success
                        $('.tooltip-wrapper').remove();

console.log('success: ',$this.children('td').first().html(),data);

                        $this.children('td').first().css('position','relative');
                        $this.children('td').first().append(data);
                        
console.log($this.children('td').first().html());                        
                    })
                    .fail(function( jqXHR, textStatus, errorThrown ){
                        console.log('ERROR: ',jqXHR, textStatus, errorThrown);
                    })
                    .always(function(){
                    })
                    ;
                        
                }
            }, function(){
                $this.children('td').first().css('position','');
                $('.tooltip-wrapper').remove();
            });
            
        }); // end tr hover*/
        
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
            return response.html();
            
            
            /*let perks = weapon.data.perks;
            let perkNames = [...new Set(perks.map(getName))];
            // let perkName = (perks, name) => perks.map(x=>x[name]);
console.log('weapon response:',weapon.data, 'perks:',perks, 'perk names:',perkNames);
            
            return perkNames.join(', ');*/
        }
    </script>

</body>

</html>