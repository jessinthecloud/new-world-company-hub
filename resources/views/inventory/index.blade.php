<x-app-layout>
    <x-slot name="title">
        Guild Bank
    </x-slot>
    
    <div class="py-12">
        <div id="wrapper-inner" class="max-w-7xl mx-auto lg:px-8">
            
            <x-dashboard.gated-button 
                :can="['create', \App\CompanyInventory::class, $owner]"
                :owner="$owner"
                :route="route(
                    Str::plural($ownerType).'.inventory.create', 
                    [
                        $ownerType=>$owner->slug,
                    ]
                )"
                class="mb-6"
            >
                {{ $buttonTexts['create'] ?? 'Add Item to Inventory' }}
            </x-dashboard.gated-button>
            
            <livewire:inventory-table 
                :id="null"
                :owner="$owner"
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
