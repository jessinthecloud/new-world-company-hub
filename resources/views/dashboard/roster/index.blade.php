@can('viewAny', \App\Models\Roster::class)
    <x-dashboard.section
        :title="'Roster'"
        class=""
    >
        <x-dashboard.gated-button 
            :class="\App\Models\Roster::class"
            :can="'viewAll'" 
            :route="route('rosters.index')"
        >
            View All
        </x-dashboard.gated-button>
        
        @isset($roster)
            <x-dashboard.gated-button 
                :class="\App\Models\Roster::class" 
                :can="'view'"
                :route="route('rosters.show', ['roster'=>$roster])"
                :instance="$roster"
            >
                View
            </x-dashboard.gated-button>
        @endisset
        
        <x-dashboard.gated-button 
            :class="\App\Models\Roster::class" 
            :can="'create'"
            :route="route('rosters.import.create')"
        >
            Import
        </x-dashboard.gated-button>
        
        <x-dashboard.gated-button 
            :class="\App\Models\Roster::class" 
            :can="'create'"
            :route="route('rosters.create')"
        >
            Create
        </x-dashboard.gated-button>
        
        @isset($roster)
            <x-dashboard.gated-button 
                :class="\App\Models\Roster::class" 
                :can="'update'"
                :route="route('rosters.choose')"
                :instance="$roster"
            >
                Edit / Delete
            </x-dashboard.gated-button>
        @endisset
    </x-dashboard.section>
@endcan
