    @props(['equipment'])

<tr class="item-wrapper border border-{{ $equipment['rarity'] }}-100 text-gray-800 bg-{{$equipment['rarity']}}-50">
   
        {{--@isset($equipment['equippableItem']->base?->icon)
            <div class="item-icon w-12 h-12 border border-{{ $equipment['rarity'] }}-500 shadow-md">
                <img src="{{ $equipment['equippableItem']->base->icon }}" alt="{{ $equipment['equippableItem']->name }}">
            </div>
        @endisset--}}
    {{-- score --}}
    <td class="p-2 item-gear-score font-bold">
        {{ $equipment['equippableItem']->gear_score }}
    </td>
    {{-- attributes --}}
    <td class="p-2 ">
        @if(!empty($equipment['attributes_list']))
            {!! $equipment['attributes_list'] !!}
        @endif
    </td>
    {{-- type --}}
    <td class="p-2 item-type">
        {{ $equipment['equippableItem']->type }}
    </td>
    {{-- weight class --}}
    <td class="p-2 item-weight-class italic">
    @isset($equipment['equippableItem']->weight_class)
        {{ $equipment['equippableItem']->weight_class }}
        @endisset
    </td>
    {{-- perks --}}
    <td class="p-2 ">
        @if(!empty($equipment['perks_list']))
            {!! $equipment['perks_list'] !!}
        @endif
    </td>
    {{-- rarity --}}
    <td class="p-2 item-rarity font-bold">
        {{ $equipment['equippableItem']->rarity }}
    </td>
    
</tr>
