@can('viewAny', \App\Models\BaseWeapon::class)
    <x-dashboard.section
        :title="'Weapon'"
        class=""
    >
        <x-dashboard.gated-button 
            :class="\App\Models\BaseWeapon::class"
            :can="'viewAll'" 
            :route="route('weapons.index')"
        >
            View All
        </x-dashboard.gated-button>
        
        @isset($weapon)
            <x-dashboard.gated-button 
                :class="\App\Models\BaseWeapon::class" 
                :can="'view'"
                :route="route('weapons.show', ['weapon'=>$weapon])"
                :instance="$weapon"
            >
                View
            </x-dashboard.gated-button>
        @endisset
        
        <x-dashboard.gated-button 
            :class="\App\Models\BaseWeapon::class" 
            :can="'create'"
            :route="route('weapons.create')"
        >
            Create
        </x-dashboard.gated-button>
        
        <x-dashboard.gated-button 
            :class="\App\Models\BaseWeapon::class" 
            :can="'update'"
            :route="route('weapons.choose')"
            :instance="$weapon ?? null"
        >
            Edit / Delete
        </x-dashboard.gated-button>
        
    </x-dashboard.section>
@endcan
