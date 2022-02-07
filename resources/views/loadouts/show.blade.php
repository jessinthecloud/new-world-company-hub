<x-app-layout>
    <x-slot name="title">
        Loadout / {{ Str::title($loadout->character->name) }}
    </x-slot>
    <?php dump($loadout->main->item->itemable->owner()::class, Str::afterLast(strtolower($loadout->main->item->itemable->owner()::class), '\\')); ?>
    <div class="py-12">
        <div id="wrapper-inner" class="max-w-7xl mx-auto flex flex-wrap sm:px-6 lg:px-8">
            <x-game-data.item-show
                :item="$loadout->main"
                :itemType="'Weapon'"
                :owner="$loadout->main->item->itemable->owner()"
                :inventory="$loadout->main->item->itemable->ownerInventory()"
                :ownerType="Str::afterLast(strtolower($loadout->main->item->itemable->owner()::class), '\\')"
            >
                <x-game-data.item-details 
                    :item="$loadout->main->item->itemable"
                    :rarityColor="\App\Enums\Rarity::from($loadout->main->item->itemable->rarity)->color()"
                    :rarity="$loadout->rarity"
                    :itemAttributes="$loadout->main->attributes?->map(function($attribute){
                        return \App\Enums\AttributeType::fromName($attribute->name)->value;
                    })->all()"
                    :emptySlots="$empty_slots ?? null"
                />
            </x-game-data.item-show>
        </div>
    </div>

</x-app-layout>
