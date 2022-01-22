@props(['item', 'itemType', 'itemClass'=>null, 'guildBank', 'guildBankClass'=>\App\GuildBank::class,])

<div {{ $attributes->merge(['class' => 'flex flex-wrap']) }}>
    @if(Route::has('guild-banks.edit'))
        <x-dashboard.gated-button 
            :can="['update', $guildBank]"
            :phpClass="$guildBankClass"
            :route="route('guild-banks.edit', [
                'guildBank' => $guildBank->slug,
                'itemType' => $itemType ?? $item->type,
                'item' => $item->slug
            ])"
            class="px-2"
        >
            Edit
        </x-dashboard.gated-button>
    @endif
    
    @if(Route::has('guild-banks.destroy'))
        @can("delete", $guildBank)
            <x-forms.form
                {{-- send as plain html attribute --}}
                action="{{  route('guild-banks.destroy', [
                    'guildBank' => $guildBank->slug,
                    'itemType' => $itemType ?? $item->type,
                    'item' => $item->id,
                    'action'=>'destroy',
                ]) }}"
                {{-- set the custom $method variable --}}
                {{-- (not the form method attribute) --}}
                :method="'DELETE'"
            >
                <x-slot name="button">
                    <x-button 
                        name="action" 
                        value="delete" 
                        class="bg-red-800"
                    >
                        Delete
                    </x-button>
                </x-slot>
            </x-forms.form>
        @endcan
    @endif
</div>