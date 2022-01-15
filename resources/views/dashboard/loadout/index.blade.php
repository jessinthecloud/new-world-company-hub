@can('viewAny', \App\Models\Loadout::class)
    <x-dashboard.section
        :title="'Loadout'"
        class=""
    >
        <x-dashboard.gated-button 
            :class="\App\Models\Loadout::class"
            :can="'viewAll'" 
            :route="route('loadouts.index')"
        >
            View All
        </x-dashboard.gated-button>
        
        @isset($loadout)
            <x-dashboard.gated-button 
                :class="\App\Models\Loadout::class" 
                :can="'view'"
                :route="route('loadouts.show', ['loadout'=>$loadout])"
                :instance="$loadout"
            >
                View
            </x-dashboard.gated-button>
        @endisset
        
        <x-dashboard.gated-button 
            :class="\App\Models\Loadout::class" 
            :can="'create'"
            :route="route('loadouts.create')"
        >
            Create
        </x-dashboard.gated-button>
        
        <x-dashboard.gated-button 
            :class="\App\Models\Loadout::class" 
            :can="'update'"
            :route="route('loadouts.choose')"
            :instance="$loadout ?? null"
        >
            Edit / Delete
        </x-dashboard.gated-button>
    </x-dashboard.section>
@endcan
