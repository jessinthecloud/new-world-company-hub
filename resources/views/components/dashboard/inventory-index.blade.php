@props(['inventory', 'ownerType', 'owner', 'inventoryItem'=>null, 'title', 'buttonTexts'=>[],])

@can('viewAny', \App\CompanyInventory::class)
    <x-dashboard.section
        :title="$title"
        class=""
    >
        <x-dashboard.gated-button
            :can="['viewAll', \App\CompanyInventory::class]"
            :phpClass="null"
            :route="route(Str::plural($ownerType).'.inventory.index',[
                $ownerType => $owner->slug,
            ])"
        >
            {{ $buttonTexts['viewAll'] ?? 'View All' }}
        </x-dashboard.gated-button>
        
        <x-dashboard.gated-button 
            :can="['create', $inventory]"
            :route="route(
                Str::plural($ownerType).'.inventory.create', 
                [
                    $ownerType=>$owner->slug,
                ]
            )"
        >
            {{ $buttonTexts['create'] ?? 'Add Item to Inventory' }}
        </x-dashboard.gated-button>
        
            
        {!! $slot !!}
        
    </x-dashboard.section>
@endcan
