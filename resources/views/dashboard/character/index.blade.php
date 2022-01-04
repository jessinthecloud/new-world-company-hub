@can('viewAny', \App\Models\Character::class)
    <x-dashboard.section
        :title="'Character'"
        class=""
    >
        <x-dashboard.view-all-button 
            :class="\App\Models\Character::class" 
            :route="route('characters.index')"
        />
        <x-dashboard.view-own-button 
            :class="\App\Models\Character::class" 
            :route="route('characters.show', ['character'=>$character])"
            :instance="$character"
        />
        <x-dashboard.create-button 
            :class="\App\Models\Character::class" 
            :route="route('characters.create')"
            :instance="$character"
        />
        <x-dashboard.edit-delete-button 
            :class="\App\Models\Character::class" 
            :route="route('characters.choose')"
            :instance="$character"
        />
    </x-dashboard.section>
@endcan
