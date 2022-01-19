<x-app-layout>
    <x-slot name="title">
        Weapons / {{ Str::title($weapon->name) }}
    </x-slot>
    
    @if(!empty(session('status')))
    <!-- Session Status -->
        <x-auth-session-status class="mb-6" :status="session('status')" />
    @endif
    
    <div class="py-12">
        <div id="wrapper-inner" class="max-w-7xl mx-auto flex flex-wrap sm:px-6 lg:px-8">
<!--            --><?php //dump($weapon); ?>
            <x-game-data.item-details 
                :item="$weapon"
                :rarityColor="$rarity_color"
                :rarity="$rarity"
                :itemAttributes="$item_attributes"
                :emptySlots="$empty_slots"
            />
        </div>
    </div>

</x-app-layout>
