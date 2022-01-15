@can('viewAny', \App\Models\Company::class)
    <x-dashboard.section
        :title="'Company'"
        class=""
    >
        <x-dashboard.gated-button 
            :class="\App\Models\Company::class"
            :can="'viewAll'" 
            :route="route('companies.index')"
        >
            View All
        </x-dashboard.gated-button>
        
        @isset($company)
            <x-dashboard.gated-button 
                :class="\App\Models\Company::class"
                :can="'view'"
                :route="route('companies.show', ['company'=>$company])"
                :instance="$company"
            >
                View
            </x-dashboard.gated-button>
        @endisset
        
        <x-dashboard.gated-button 
            :class="\App\Models\Company::class" 
            :can="'create'"
            :route="route('companies.create')"
        >
            Create
        </x-dashboard.gated-button>
        
        <x-dashboard.gated-button 
            :class="\App\Models\Company::class" 
            :can="'update'"
            :route="route('companies.choose')"
            :instance="$company ?? null"
        >
            Edit / Delete
        </x-dashboard.gated-button>
    </x-dashboard.section>
@endcan
