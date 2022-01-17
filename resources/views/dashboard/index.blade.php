<x-layouts.dashboard>
    
        {{-- If use has no access, tell them they're a loser --}}
    @empty(Auth::user()->getAllPermissions()->all())
        <div class="w-full
            sm:px-6 
            lg:px-8
        ">
            <x-dashboard.section
                :title="'No.'"
                class="mx-auto text-center
                lg:w-1/2"
            >
                <img class="mx-auto text-center" src="{{ Storage::url('no.gif') }}" alt="Ron Swanson: No.">
                
                <p>Come back later with a hall pass. <BR>
                Maybe.</p>
                <p class="text-xs">We're not giving out hall passes yet.</p>
                {{--<p><a href="">Ask nicely for a hall pass</a></p>--}}
            </x-dashboard.section>
        </div>
    @else 
        <div class="w-full grid grid-cols-1 auto-rows-min gap-4 
            sm:px-6 
            md:grid-cols-2
            lg:px-8 lg:gap-6 lg:grid-cols-3
        ">
                {{-- Faction --}}
            <x-dashboard.resource-index
                :title="'Faction'"
                :phpClass="\App\Models\Faction::class" 
                :entityName="'faction'"
                :pluralEntityName="'factions'"
                :instance="$faction ?? null"
            />
            
            {{-- Company --}}
            <x-dashboard.resource-index
                :title="'Company'"
                :phpClass="\App\Models\Companies\Company::class" 
                :entityName="'company'"
                :pluralEntityName="'companies'"
                :instance="$company ?? null"
            />
            
            {{-- Roster --}}
            <x-dashboard.resource-index
                :title="'Roster'"
                :phpClass="\App\Models\Companies\Roster::class" 
                :entityName="'roster'"
                :pluralEntityName="'rosters'"
                :instance="$roster ?? null"
            >
                <x-dashboard.gated-button
                    :can="['import', \App\Models\Companies\Roster::class]"
                    :phpClass="\App\Models\Companies\Roster::class" 
                    :route="route('rosters.import.create')"
                >
                    Import
                </x-dashboard.gated-button>
            </x-dashboard.resource-index>
            
            {{-- Guild Bank --}}
            <x-dashboard.resource-index
                :title="'Guild Bank'"
                :phpClass="\App\GuildBank::class" 
                :entityName="'guild_bank'"
                :pluralEntityName="'guild-banks'"
                :instance="$guildBank ?? null"
            />
            
            {{-- Character --}}
            <x-dashboard.resource-index
                :title="'Character'"
                :phpClass="\App\Models\Characters\Character::class" 
                :entityName="'character'"
                :pluralEntityName="'characters'"
                :instance="$character ?? null"
            />
            
            {{-- Loadout --}}
            <x-dashboard.resource-index
                :title="'Loadout'"
                :phpClass="\App\Models\Characters\Loadout::class" 
                :entityName="'loadout'"
                :pluralEntityName="'loadouts'"
                :instance="$loadout ?? null"
            />
            
            {{-- Weapon --}}
            <x-dashboard.resource-index
                :title="'Weapon'"
                :phpClass="\App\Models\Items\Weapon::class" 
                :entityName="'weapon'"
                :pluralEntityName="'weapons'"
                :instance="$weapon ?? null"
            />
        </div>
    @endempty

        
</x-layouts.dashboard>
