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
    
    {{-- Companies --}}
    @include('dashboard.company.index')

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
