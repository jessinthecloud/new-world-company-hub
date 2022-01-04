<x-layouts.dashboard>
    
    {{-- Faction --}}
    @include('dashboard.faction.index')
    
    {{-- Company --}}
    @include('dashboard.company.index')
    
    <x-dashboard.section 
        :title="'Import'"
        class="min-w-1/3 mb-6 lg:mr-6"
    >
        <x-button-link href="{{ route('import.create') }}">
            Import Roster
        </x-button-link>
    </x-dashboard.section>
    
    <x-dashboard.section 
        :title="'Roster'"
        class="min-w-1/3 mb-6"
    >
        <x-button-link href="{{-- route('rosters.index') --}}">
            View All
        </x-button-link>
    </x-dashboard.section>

    <x-dashboard.section 
        :title="'Character'"
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
        :title="'Loadout'"
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
        :title="'Weapon'"
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
