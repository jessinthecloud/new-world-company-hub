<x-layouts.dashboard>
    
    {{-- Faction --}}
    @include('dashboard.faction.index')
    
    {{-- Company --}}
    @include('dashboard.company.index')
    
    {{-- Character --}}
    @include('dashboard.character.index')
    
    {{-- Loadout --}}
    @include('dashboard.loadout.index')
    
    {{-- Weapon --}}
    @include('dashboard.weapon.index')
    
    <x-dashboard.section 
        :title="'Import'"
        class=""
    >
        <x-button-link href="{{ route('import.create') }}">
            Import Roster
        </x-button-link>
    </x-dashboard.section>
       
</x-layouts.dashboard>
