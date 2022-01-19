@props(['item', 'rarity', 'rarityColor', 'itemAttributes'])

<!--            --><?php //dump($item); ?>
<div class="item-wrapper w-3/4 mx-auto flex flex-wrap border border-{{ $rarity }}-700">
    <div class="item-heading w-full flex flex-wrap gap-4 items-center bg-gradient-to-b from-gray-700 via-{{$rarity}}-800 to-{{$rarity}}-800 p-4 text-gray-200 text-shadow"
    > 
        @isset($item->base?->icon)
            <div class="item-icon w-24 h-24 border border-{{ $rarity }}-500 shadow-md">
                <img src="{{ $item->base->icon }}" alt="{{ $item->name }}">
            </div>
        @endisset
        <div class="item-gear-score text-5xl font-bold mx-4">
            {{ $item->gear_score }}
        </div>
        <div class="item-name-details flex flex-wrap gap-2 text-xl">
            <h1 class="item-name w-full text-{{ $rarity }}-400">
                {{ $item->name }}
            </h1>
            @isset($item->weight_class)
                <div class="item-weight-class mt-2 italic">
                    {{ $item->weight_class }}
                </div>
            @endisset
            <div class="item-type mt-2">
                {{ $item->type }}
            </div>
            <div class="item-rarity mt-2 font-bold text-{{ $rarity }}-400">
                {{ $item->rarity }}
            </div>
        </div>
    </div>
    
    @isset($item->perks)
        <div class="w-full lg:w-1/2 p-4">
            <h2 class="w-full">Perks</h2>
            <dl>
                @foreach($item->perks as $perk)
                    <dt class="font-bold">{{ $perk->name }}</dt>
                    <dd class="mb-3">{{ $perk->description }}</dd>
                @endforeach
            </dl>
        </div>
    @endisset
    
    @isset($item->attributes)
        <div class="w-1/2 p-4">
            <h2 class="w-full">Attributes</h2>
            <ul>
                @foreach($item->attributes as $index => $attribute)
                    <li>{{ $attribute->pivot->amount }} {{ $itemAttributes[$index] }}</li>
                @endforeach
            </ul>
        </div>
    @endisset
</div>
