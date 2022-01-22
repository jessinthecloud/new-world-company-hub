<x-app-layout>
    <x-slot name="title">
        Guild Bank
    </x-slot>
    
    <div class="py-12">
        <div id="wrapper-inner" class="max-w-7xl mx-auto lg:px-8">
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
