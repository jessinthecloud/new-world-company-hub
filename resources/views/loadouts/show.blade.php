<x-app-layout>
    <x-slot name="title">
        <strong class="ml-2">{{ $gear_score }}</strong> / Loadout / {{ $character_name }}
    </x-slot>
    
    <div class="py-6">
        <div id="wrapper-inner" class="max-w-7xl mx-auto flex flex-wrap sm:px-6 lg:px-8">
            <table class="w-full text-sm">
                <tr><td class="pt-4 pb-2 text-lg font-bold">Weapons</td></tr>
                @foreach($weapon_slot as $equipment)
                    <x-game-data.loadout-details :equipment="$equipment" />
                @endforeach
            
                <tr><td class="pt-4 pb-2 text-lg font-bold">Armor</td></tr>
                @foreach($armor_slot as $equipment)
                    <x-game-data.loadout-details :equipment="$equipment" />
                @endforeach
            
                <tr><td class="pt-4 pb-2 text-lg font-bold">Jewelry</td></tr>
                @foreach($jewelry_slot as $equipment)
                    <x-game-data.loadout-details :equipment="$equipment" />
                @endforeach
            </table>
        </div>
    </div>

</x-app-layout>
