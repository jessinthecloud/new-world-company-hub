<x-layouts.dashboard>
    <div class="w-full grid grid-cols-1 auto-rows-min gap-4 
        sm:px-6 
        md:grid-cols-2
        lg:px-8 lg:gap-6 lg:grid-cols-3
    ">
        {{-- Faction --}}
        @include('dashboard.faction.index')
        
        {{-- Company --}}
        @include('dashboard.company.index')
        
        {{-- Roster --}}
        @include('dashboard.roster.index')
        
        {{-- Guild Bank --}}
        @include('dashboard.guild-bank.index')
        
        {{-- Character --}}
        @include('dashboard.character.index')
        
        {{-- Loadout --}}
        @include('dashboard.loadout.index')
        
        {{-- Weapon --}}
        @include('dashboard.weapon.index')
    </div>
</x-layouts.dashboard>
