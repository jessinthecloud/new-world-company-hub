@props(['item', 'itemType'=>null, 'itemClass'=>null, 'inventory', 'owner', 'ownerType'])

<div class="item-show w-full lg:w-3/4 mx-auto flex flex-wrap">
    @isset($inventory)
    <x-dashboard.gated-button 
        :can="['view', $inventory]"
        :route="route(
            Str::plural($ownerType).'.inventory.index',
            [$ownerType => $owner->slug]
        )"
         class="mb-6"
    >
        < Back to Guild Bank
    </x-dashboard.gated-button>
    @endisset
    
    {{ $slot }}
    
    @isset($inventory)
    <x-dashboard.edit-delete-inventory-item-buttons
        :item="$item"
        :inventory="$inventory"
        :owner="$owner"
        :ownerType="Str::afterLast(strtolower($owner::class), '\\')"
        class="w-full mt-4 justify-end"
    />
    @endisset
</div>


    