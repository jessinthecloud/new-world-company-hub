@can('viewAny', \App\Models\Faction::class)
    <x-dashboard.section
        :title="'Faction'"
        class=""
    >
        <x-dashboard.view-all-button 
            :class="\App\Models\Faction::class" 
            :route="route('factions.index')"
        />
        <x-dashboard.view-own-button 
            :class="\App\Models\Faction::class" 
            :route="route('factions.show', ['faction'=>$faction])"
            :instance="$faction"
        />
        <x-dashboard.create-button 
            :class="\App\Models\Faction::class" 
            :route="route('factions.create')"
            :instance="$faction"
        />
        <x-dashboard.edit-delete-button 
            :class="\App\Models\Faction::class" 
            :route="route('factions.choose')"
            :instance="$faction"
        />
    </x-dashboard.section>
@endcan

