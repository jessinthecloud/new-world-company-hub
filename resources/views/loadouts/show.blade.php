<x-app-layout>
    <x-slot name="title">
        Loadout / {{ $character_name }}
    </x-slot>
    
    <div class="py-12">
        <div id="wrapper-inner" class="max-w-7xl mx-auto flex flex-wrap sm:px-6 lg:px-8">
            <h2 class="mb-4 flex flex-wrap items-center lg:flex-nowrap">
                Overall Gear Score: <strong class="ml-2">{{ $gear_score }}</strong>
                @if(!empty($loadout_check))
                    <x-utils.icons.checkmark class="ml-2 text-acceptable-800"/>
                @else
                    <x-utils.icons.xmark class="ml-2 text-toolow-700"/>
                @endif
            </h2>
            @foreach($equipment_slot as $equipment)
                <x-game-data.loadout-details :equipment="$equipment" />
            @endforeach
        </div>
    </div>

</x-app-layout>
