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
            :route="route('guild-banks.show', ['guild_bank'=>$guildBank])"
            :instance="$guildBank"
        >
            View Inventory
        </x-dashboard.view-own-button>
        @endisset
        <x-dashboard.create-button 
            :class="\App\Models\GuildBank::class" 
            :route="route('guild-banks.create')"
            :instance="$guildBank ?? null"
        />
        <x-dashboard.edit-delete-button 
            :class="\App\Models\GuildBank::class" 
            :route="isset($guildBank) ? route('guild-banks.edit', ['guild_bank'=>$guildBank]) : route('guild-banks.choose')"
            :instance="$guildBank ?? null"
        >
            Edit Inventory
        </x-dashboard.edit-delete-button>
    </x-dashboard.section>
@endcan
