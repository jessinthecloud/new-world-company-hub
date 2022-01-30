@props(['ownerType', 'owner', 'inventoryItem'=>null, 'title', 'buttonTexts'=>[],])

@can('viewAny')
    <x-dashboard.section
        :title="$title"
        class=""
    >
        <x-dashboard.gated-button
            :can="['viewAll', null]"
            :phpClass="null"
            :route="route(Str::plural($ownerType).'.inventory.index',[
                $ownerType => $owner->slug,
            ])"
        >
            {{ $buttonTexts['viewAll'] ?? 'View All' }}
        </x-dashboard.gated-button>
        
        <x-dashboard.gated-button 
            :can="['create', $owner]"
            :route="route(
                Str::plural($ownerType).'.inventory.create', 
                [
                    $ownerType=>$owner->slug,
                ]
            )"
        >
            {{ $buttonTexts['create'] ?? 'Create' }}
        </x-dashboard.gated-button>
        
            
        {!! $slot !!}
        
    </x-dashboard.section>
@endcan
