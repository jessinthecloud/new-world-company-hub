@props(['item', 'itemType'=>null, 'itemClass'=>null, 'owner', 'ownerType'])

<div class="item-show w-full lg:w-3/4 mx-auto flex flex-wrap">
    
    <x-dashboard.gated-button 
        :can="['view', \App\CompanyInventory::class, $owner]"
        :route="route(
            Str::plural($ownerType).'.inventory.index',
            [$ownerType => $owner->slug]
        )"
         class="mb-6"
    >
        < Back to Guild Bank
    </x-dashboard.gated-button>

    {{ $slot }}
    
    <x-dashboard.edit-delete-inventory-item-buttons
        :item="$item"
        :owner="$owner"
        :ownerType="Str::afterLast(strtolower($owner::class), '\\')"
        class="w-full mt-4 justify-end"
    />
</div>


    