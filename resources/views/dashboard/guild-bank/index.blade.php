@can('viewAny', \App\Models\GuildBank::class)
    <x-dashboard.section
        :title="'Guild Bank'"
        class=""
    >
        <x-dashboard.view-all-button 
            :class="\App\Models\GuildBank::class" 
            :route="route('guild-banks.index')"
        />
        @isset($guildBank)
        <x-dashboard.view-own-button 
            :class="\App\Models\GuildBank::class" 
            :route="route('guild-banks.show', ['guildBank'=>$guildBank])"
            :instance="$guildBank"
        />
        @endisset
        <x-dashboard.create-button 
            :class="\App\Models\GuildBank::class" 
            :route="route('guild-banks.create')"
            :instance="$guildBank ?? null"
        />
        <x-dashboard.edit-delete-button 
            :class="\App\Models\GuildBank::class" 
            :route="route('guild-banks.choose')"
            :instance="$guildBank ?? null"
        />
    </x-dashboard.section>
@endcan
