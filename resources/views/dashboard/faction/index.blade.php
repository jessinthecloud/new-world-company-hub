@can('viewAny', \App\Models\Faction::class)
    <x-dashboard.section
        :title="'Faction'"
        class=""
    >
        <x-dashboard.gated-button 
            :class="\App\Models\Faction::class"
            :can="'viewAll'" 
            :route="route('factions.index')"
        >
            View All
        </x-dashboard.gated-button>
        
        @isset($faction)
            <x-dashboard.gated-button 
                :class="\App\Models\Faction::class" 
                :can="'view'"
                :route="route('factions.show', ['faction'=>$faction])"
                :instance="$faction"
            >
                View
            </x-dashboard.gated-button>
        @endisset
        
        <x-dashboard.gated-button 
            :class="\App\Models\Faction::class" 
            :can="'create'"
            :route="route('factions.create')"
        >
            Create
        </x-dashboard.gated-button>
        
        <x-dashboard.gated-button 
            :class="\App\Models\Faction::class" 
            :can="'update'"
            :route="route('factions.choose')"
            :instance="$faction ?? null"
        >
            Edit / Delete
        </x-dashboard.gated-button>
    </x-dashboard.section>
@endcan

