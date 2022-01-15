@can('viewAny', \App\Models\Character::class)
    <x-dashboard.section
        :title="'Character'"
        class=""
    >
        <x-dashboard.gated-button 
            :class="\App\Models\Character::class"
            :can="'viewAll'" 
            :route="route('characters.index')"
        >
            View All
        </x-dashboard.gated-button>
        
        @isset($character)
            <x-dashboard.gated-button 
                :class="\App\Models\Character::class" 
                :can="'view'"
                :route="route('characters.show', ['character'=>$character])"
                :instance="$character"
            >
                View
            </x-dashboard.gated-button>
        @endisset
        
        <x-dashboard.gated-button 
            :class="\App\Models\Character::class" 
            :can="'create'"
            :route="route('characters.create')"
        >
            Create
        </x-dashboard.gated-button>
        
        <x-dashboard.gated-button 
            :class="\App\Models\Character::class" 
            :can="'update'"
            :route="route('characters.choose')"
            :instance="$character ?? null"
        >
            Edit / Delete
        </x-dashboard.gated-button>
    </x-dashboard.section>
@endcan
