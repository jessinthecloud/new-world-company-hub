@props(['item', 'rarity', 'rarityColor', 'itemAttributes', 'emptySlots'])

<!--            --><?php //dump($item); ?>
<div class="item-wrapper w-full mx-auto flex flex-wrap border border-{{ $rarity }}-700">
    <div class="item-heading w-full flex flex-wrap gap-4 items-center bg-gradient-to-b from-gray-700 via-{{$rarity}}-800 to-{{$rarity}}-800 p-4 text-gray-200 text-shadow
    lg:flex-nowrap
    "> 
        @isset($item->base?->icon)
            <div class="item-icon w-20 h-20 border border-{{ $rarity }}-500 shadow-md
                lg:w-24 lg:h-24
            ">
                <img src="{{ $item->base->icon }}" alt="{{ $item->name }}">
            </div>
        @endisset
        <div class="item-gear-score text-4xl font-bold mx-4
            lg:text-5xl
        ">
            {{ $item->gear_score }}
        </div>
        <div class="item-name-details flex flex-wrap gap-2 text-lg 
            lg:text-xl
        ">
            <h1 class="item-name w-full text-{{ $rarity }}-400
                text-3xl lg:text-4xl
            ">
                {{ $item->name }}
            </h1>
            @isset($item->weight_class)
                <div class="item-weight-class mt-2 italic mr-2">
                    {{ $item->weight_class }}
                </div>
            @endisset
            <div class="item-type mt-2 mr-6">
                {{ $item->type }}
            </div>
            <div class="item-rarity mt-2 font-bold text-{{ $rarity }}-400">
                {{ $item->rarity }}
            </div>
        </div>
    </div>
    
    @isset($item->perks)
        <div class="w-full py-2 px-4 lg:w-1/2 lg:py-4">
            <h2 class="w-full">Perks</h2>
            <dl>
                @foreach($item->perks->unique() as $perk)
                    <dt class="font-bold">{{ $perk->name }}</dt>
                    <dd class="mb-3">{{ $perk->description }}</dd>
                @endforeach
            </dl>
        </div>
    @endisset
    
    @isset($item->attributes)
        <div class="w-full py-2 px-4 lg:w-1/2 lg:py-4">
            <h2 class="w-full">Attributes</h2>
            <ul>
                @foreach($item->attributes->unique() as $index => $attribute)
                    <li class="mb-2">{{ $attribute->pivot->amount }} {{ $itemAttributes[$index] }}</li>
                @endforeach
            </ul>
        </div>
    @endisset
    
    @isset($emptySlots)
        <div class=" py-2 px-4 lg:w-1/2 lg:py-4">
            <h3 class="w-full">Open Slots</h3>
            <ul class="mt-1 ml-2">
                @while(--$emptySlots >= 0)
                    <li class="mb-1">Unused Slot</li>
                @endwhile
            </ul>
        </div>
    @endisset
</div>
