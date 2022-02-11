<x-app-layout>
    <x-slot name="title">
        <strong class="ml-2">{{ $gear_score }}</strong> 
        <span class="ml-2">/ Loadout</span> 
        <x-utils.icons.war-ready :loadout="$loadout"/>
    </x-slot>
    
    <div class="py-6">
        <div id="wrapper-inner" class="max-w-4xl mx-auto flex flex-wrap justify-end sm:px-6 lg:px-8">
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
            
            @if(!$loadout->approved())
                <x-utils.gated-button-form
                    :can="['approve', $loadout]"
                    :route-name="'loadouts.approve'"
                    :route=" route('loadouts.approve', [
                        'loadout' => $loadout->id,
                    ])"
                    class="mt-4"
                >
                    Approve for War
                </x-utils.gated-button-form>
            @endif
        </div>
    </div>

</x-app-layout>
