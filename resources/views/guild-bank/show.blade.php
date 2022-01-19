<x-app-layout>
    <x-slot name="title">
        Guild Bank
    </x-slot>
    
    @if(!empty(session('status')))
    <!-- Session Status -->
        <x-auth-session-status class="mb-6" :status="session('status')" />
    @endif
    
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
