@can('viewAny', \App\Models\Roster::class)
    <x-dashboard.section
        :title="'Roster'"
        class=""
    >
        <x-dashboard.view-all-button 
            :class="\App\Models\Roster::class" 
            :route="route('rosters.index')"
        />
        @isset($roster)
            <x-dashboard.view-own-button 
                :class="\App\Models\Roster::class" 
                :route="route('rosters.show', ['roster'=>$roster])"
                :instance="$roster"
            />
        @endisset
        <x-dashboard.import-button 
            :class="\App\Models\Roster::class" 
            :route="route('rosters.import.create')"
        />
        <x-dashboard.create-button 
            :class="\App\Models\Roster::class" 
            :route="route('rosters.create')"
        />
        @isset($roster)
            <x-dashboard.edit-delete-button 
                :class="\App\Models\Roster::class" 
                :route="route('rosters.choose')"
                :instance="$roster"
            />
        @endisset
    </x-dashboard.section>
@endcan
