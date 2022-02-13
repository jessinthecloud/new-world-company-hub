<x-app-layout>
    <x-slot name="title">
        <strong class="ml-2">{{ $gear_score }}</strong> 
        <span class="ml-2">/ Loadout</span> 
        <x-utils.icons.war-ready :loadout="$loadout" class=""ml-2/>
    </x-slot>
    
    <div class="py-6">
        <div id="wrapper-inner" class="max-w-4xl mx-auto flex flex-wrap justify-end sm:px-6 lg:px-8">
        
            <x-dashboard.gated-button
                :can="['update', $loadout]"
                :route-name="'loadouts.edit'"
                :route=" route('loadouts.edit', [
                    'loadout' => $loadout->id,
                ])"
                class="mt-4"
            >
                Edit Loadout
            </x-dashboard.gated-button>
        
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
            
{{--            @if(!Auth::user()->is($loadout->user))--}}
                {{-- if current user is not the owner, 
                see if they can approve/disapprove gear--}}
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
                @else
                    <x-utils.gated-button-form
                        :can="['delete', $loadout]"
                        :route-name="'loadouts.destroy'"
                        :route=" route('loadouts.destroy', [
                            'loadout' => $loadout->id,
                        ])"
                        :method="'DELETE'"
                        class="mt-4"
                    >
                        Remove War Approval
                    </x-utils.gated-button-form>
                @endif
{{--            @endif--}}
        </div>
    </div>

</x-app-layout>
