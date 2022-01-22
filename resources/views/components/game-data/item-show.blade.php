@props(['item', 'itemType'=>null, 'itemClass'=>null, 'guildBank', 'guildBankClass'=>\App\GuildBank::class,])

<div class="item-show w-full lg:w-3/4 mx-auto flex flex-wrap">
    
    <x-dashboard.gated-button 
        :can="['view', $guildBank]"
        :phpClass="$guildBankClass"
        :route="route(
            'guild-banks.show',
            ['guildBank'=>$guildBank->slug]
        )"
         class="mb-6"
    >
        < Back to Guild Bank
    </x-dashboard.gated-button>

    {{ $slot }}
    
    <x-dashboard.edit-delete-bank-item-buttons
        :item="$item"
        :itemType="$itemType ?? $item->type"
        :guildBank="$guildBank"
        :guildBankClass="$guildBankClass"
        class="w-full mt-4 justify-end"
    />
</div>


    