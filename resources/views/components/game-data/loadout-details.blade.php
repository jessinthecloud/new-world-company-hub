@props(['equipment'])

<div class="item-wrapper w-full mx-auto flex flex-wrap border border-{{ $equipment['gear_check_label'] }}-400">
    <div class="item-heading w-full flex flex-wrap gap-4 items-center bg-{{$equipment['gear_check_label']}}-300 p-4 text-gray-800 {{--text-shadow--}}
    lg:flex-nowrap
    lg:text-lg
    "> 
        {{--@isset($equipment['equippableItem']->base?->icon)
            <div class="item-icon w-12 h-12 border border-{{ $equipment['rarity'] }}-500 shadow-md">
                <img src="{{ $equipment['equippableItem']->base->icon }}" alt="{{ $equipment['equippableItem']->name }}">
            </div>
        @endisset--}}
        <div class="item-gear-score font-bold mx-4">
            @if(!empty($equipment['gear_check_status']))
                <x-utils.icons.checkmark/>
            @else
                <x-utils.icons.xmark class="text-toolow-700"/>
            @endif
        </div>
        
        <div class="item-gear-score font-bold mx-4">
            {{ $equipment['equippableItem']->gear_score }}
        </div>
        <div class="item-name">
            {{ $equipment['equippableItem']->name }}
        </div>
        @isset($equipment['equippableItem']->weight_class)
            <div class="item-weight-class italic mr-2">
                {{ $equipment['equippableItem']->weight_class }}
            </div>
        @endisset
        <div class="item-type mr-6">
            {{ $equipment['equippableItem']->type }}
        </div>
        <div class="item-rarity font-bold text-shadow-sm text-{{ $equipment['rarity'] }}-400">
            {{ $equipment['equippableItem']->rarity }}
        </div>
    </div>
    @if(!empty($equipment['perks_list']) && !empty($equipment['attributes_list']))
        <div class="attr-perk w-full flex flex-wrap bg-{{$equipment['gear_check_label']}}-50 ">
            <div class="spacer w-24 h-6"></div>
            @if(!empty($equipment['perks_list']))
                <div class="w-full py-2 px-4 lg:w-auto lg:py-4">
                    <span class="font-bold">Perks:</span> {{ $equipment['perks_list'] }}
                </div>
            @endif
            
            @if(!empty($equipment['attributes_list']))
                <div class="w-full py-2 px-4 lg:w-auto lg:py-4">
                    <span class="font-bold">Attributes:</span>
                    {{ $equipment['attributes_list'] }}
                </div>
            @endif
        </div>
    @endif
    
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
