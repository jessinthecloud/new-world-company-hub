@props(['item', 'itemClass'=>null, 'owner', 'ownerType',])

<div {{ $attributes->merge(['class' => 'flex flex-wrap']) }}>
    <x-dashboard.gated-button 
        :can="['update', \App\CompanyInventory::class, $owner]"
        :route="route(Str::plural($ownerType).'.inventory.edit', [
            $ownerType => $owner->slug,
            'inventoryItem' => $item->id
        ])"
        class="px-2"
    >
        Edit
    </x-dashboard.gated-button>

    @can("delete", $owner)
        <x-forms.form
            action="{{  route(Str::plural($ownerType).'.inventory.destroy', [
                $ownerType => $owner->slug,
                'inventoryItem' => $item->id,
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
</div>