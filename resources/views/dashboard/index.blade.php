<x-layouts.dashboard>
    
    <x-dashboard.section 
        :title="'Import'"
        class="min-w-1/3 mb-6 lg:mr-6"
    >
        <x-button-link href="{{ route('import.create') }}">
            Import Roster
        </x-button-link>
    </x-dashboard.section>
    
    <x-dashboard.section 
        :title="'Rosters'"
        class="min-w-1/3 mb-6"
    >
        <x-button-link href="{{-- route('rosters.index') --}}">
            View All
        </x-button-link>
    </x-dashboard.section>

    <x-dashboard.section 
        :title="'Characters'"
        class="min-w-1/3 mb-6 lg:mr-6"
    >
        <x-button-link href="{{ route('characters.index') }}">
            View All
        </x-button-link>
        
        <x-button-link href="{{ route('characters.create') }}">
            Create
        </x-button-link>

        <x-button-link href="{{ route('characters.choose') }}">
            Edit / Delete
        </x-button-link>
    </x-dashboard.section>

    <x-dashboard.section
        :title="'Loadouts'"
        class="min-w-1/3 mb-6"
    >
        <x-button-link href="{{ route('loadouts.index') }}">
            View All
        </x-button-link>
        
        <x-button-link href="{{ route('loadouts.create') }}">
            Create
        </x-button-link>

        <x-button-link href="{{ route('loadouts.choose') }}">
            Edit / Delete
        </x-button-link>
    </x-dashboard.section>

    <x-dashboard.section
        :title="'Companies'"
        class="min-w-1/3 mb-6 lg:mr-6"
    >
        <x-button-link href="{{ route('companies.index') }}">
            View All
        </x-button-link>
    
        <x-button-link href="{{ route('companies.create') }}">
            Create
        </x-button-link>

        <x-button-link href="{{ route('companies.choose') }}">
            Edit / Delete
        </x-button-link>
        
        <x-forms.form
            {{-- send as plain html attribute --}}
            action="{{ route('companies.find') }}"
            {{-- set the custom $method variable --}}
            {{-- (not the form method attribute) --}}
            :method="$method ?? null"
            class="w-full mx-0 mt-8"
        >
            <x-forms.field :name="'company'" class="w-full">
                <x-forms.label for="company" :required="true" class="inline-block text-lg mr-2">
                    View all members for:
                </x-forms.label>
                <x-forms.select id="company" type="text" name="company" class="inline-block" 
                    :required="true" 
                    :values="
                        \App\Models\Company::with('faction')
                            ->orderBy('name')->get()
                            ->mapWithKeys(function($company){
                                return [$company->slug => $company->name.' ('.$company->faction->name.')'];
                            })
                            ->all()
                    "
                />
            </x-forms.field>
            
            <x-slot name="button">
                <div class="flex flex-wrap">
                    <x-button name="action" value="show">View All Members</x-button>
                </div>
            </x-slot>
            
        </x-forms.form>
        
    </x-dashboard.section>

    <x-dashboard.section
        :title="'Factions'"
        class="min-w-1/3  mb-6"
    >
        <x-button-link href="{{ route('factions.index') }}">
            View All
        </x-button-link>
        
        <x-button-link href="{{ route('factions.create') }}">
            Create
        </x-button-link>

        <x-button-link href="{{ route('factions.choose') }}">
            Edit / Delete
        </x-button-link>
    </x-dashboard.section>
    
    <x-dashboard.section
        :title="'Weapons'"
        class="min-w-1/3  mb-6"
    >
        <x-button-link href="{{ route('weapons.index') }}">
            View All
        </x-button-link>
        
        <x-button-link href="{{ route('weapons.create') }}">
            Create
        </x-button-link>

        <x-button-link href="{{ route('weapons.choose') }}">
            Edit / Delete
        </x-button-link>
    </x-dashboard.section>
       
</x-layouts.dashboard>
