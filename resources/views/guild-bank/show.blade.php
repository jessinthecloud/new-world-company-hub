<x-app-layout>
    <x-slot name="title">
        Guild Bank
    </x-slot>
    
    <div class="py-12">
        <div id="wrapper-inner" class="max-w-7xl mx-auto lg:px-8">
            
            @if(Route::has('guild-banks.create'))
                <x-dashboard.gated-button 
                    :can="['create', \App\GuildBank::class]"
                    :phpClass="\App\GuildBank::class"
                    :route="route(
                        'guild-banks.create',
                        ['guildBank'=>$guildBank->slug]
                    )"
                     class="mb-6"
                >
                    Add Item to Inventory
                </x-dashboard.gated-button>
            @endif
            
            <livewire:guild-bank-table 
                :id="null"
                :guildBank="$guildBank"
                :company="$company"
                :weapons="$weapons"
                :armors="$armors"
                :weight_class="$weight_class"
                :rarity="$rarity"
                :types="$types"
                :perks="$perks"
            />
        </div>
    </div>

</x-app-layout>
