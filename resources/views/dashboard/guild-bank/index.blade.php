@can('viewAny', \App\GuildBank::class)
    <x-dashboard.section
        :title="'Guild Bank'"
        class=""
    >
        <x-dashboard.gated-button 
            :class="\App\GuildBank::class"
            :can="'viewAll'"
            :route="route('guild-banks.index')"
        >
           View All
        </x-dashboard.gated-button> 
        
        @isset($guildBank)
            <x-dashboard.gated-button 
                :class="\App\GuildBank::class"
                :can="'view'"
                :route="route('guild-banks.show', [
                    'guild_bank'=>$guildBank
                ])"
                :instance="$guildBank"
            >
                View Inventory
            </x-dashboard.gated-button>
        @endisset
        
        <x-dashboard.gated-button 
            :class="\App\GuildBank::class"
            :can="'create'"
            :route="route('guild-banks.create')"
            :instance="$guildBank ?? null"
        >
            Create
        </x-dashboard.gated-button>
        
        <x-dashboard.gated-button 
            :class="\App\GuildBank::class" 
            :can="'update'"
            :route="isset($guildBank) 
                ? route('guild-banks.edit', ['guild_bank'=>$guildBank]) 
                : route('guild-banks.choose')"
            :instance="$guildBank ?? null"
        >
            Edit Inventory
        </x-dashboard.gated-button>
        
    </x-dashboard.section>
@endcan
