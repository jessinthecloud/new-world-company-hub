<x-layouts.dashboard>
    <div class="w-full grid grid-cols-1 auto-rows-min gap-4 
        sm:px-6 
        md:grid-cols-2
        lg:px-8 lg:gap-6 lg:grid-cols-3
    ">
        {{-- Faction --}}
        <x-dashboard.resource-index
            :title="'Faction'"
            :class="\App\Models\Faction::class" 
            :entity_name="'faction'"
            :pluralEntityName="'factions'"
            :instance="$faction ?? null"
        />
        
        {{-- Company --}}
        <x-dashboard.resource-index
            :title="'Company'"
            :class="\App\Models\Company::class" 
            :entity_name="'company'"
            :pluralEntityName="'companies'"
            :instance="$company ?? null"
        />
        
        {{-- Roster --}}
        <x-dashboard.resource-index
            :title="'Roster'"
            :class="\App\Models\Roster::class" 
            :entity_name="'roster'"
            :pluralEntityName="'rosters'"
            :instance="$roster ?? null"
        >
            <x-dashboard.gated-button 
                :class="\App\Models\Roster::class" 
                :can="'create'"
                :route="route('rosters.import.create')"
            >
                Import
            </x-dashboard.gated-button>
        </x-dashboard.resource-index>
        
        {{-- Guild Bank --}}
        <x-dashboard.resource-index
            :title="'Guild Bank'"
            :class="\App\GuildBank::class" 
            :entity_name="'guild_bank'"
            :pluralEntityName="'guild-banks'"
            :instance="$guildBank ?? null"
        />
        
        {{-- Character --}}
        <x-dashboard.resource-index
            :title="'Character'"
            :class="\App\Models\Character::class" 
            :entity_name="'character'"
            :pluralEntityName="'characters'"
            :instance="$character ?? null"
        />
        
        {{-- Loadout --}}
        <x-dashboard.resource-index
            :title="'Loadout'"
            :class="\App\Models\Loadout::class" 
            :entity_name="'loadout'"
            :pluralEntityName="'loadouts'"
            :instance="$loadout ?? null"
        />
        
        {{-- Weapon --}}
        <x-dashboard.resource-index
            :title="'Weapon'"
            :class="\App\Models\Items\Weapon::class" 
            :entity_name="'weapon'"
            :pluralEntityName="'weapons'"
            :instance="$weapon ?? null"
        />
    </div>
</x-layouts.dashboard>
