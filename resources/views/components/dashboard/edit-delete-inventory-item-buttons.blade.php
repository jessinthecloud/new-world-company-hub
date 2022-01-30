@props(['item', 'itemType', 'itemClass'=>null, 'owner', 'ownerType',])

<div {{ $attributes->merge(['class' => 'flex flex-wrap']) }}>
    @if(Route::has(Str::plural($ownerType).'.inventory.edit'))
        <x-dashboard.gated-button 
            :can="['update', $owner]"
            :route="route(Str::plural($ownerType).'.inventory.edit', [
                $ownerType => $owner->slug,
                'itemType' => $itemType ?? $item->type,
                'item' => $item->slug
            ])"
            class="px-2"
        >
            Edit
        </x-dashboard.gated-button>
    @endif
    
    @if(Route::has(Str::plural($ownerType).'.inventory.destroy'))
        @can("delete", $owner)
            <x-forms.form
                action="{{  route(Str::plural($ownerType).'.inventory.destroy', [
                    $ownerType => $owner->slug,
                    'itemType' => $itemType ?? $item->type,
                    'item' => $item->id,
                ]) }}"
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