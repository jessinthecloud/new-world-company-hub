<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div id="wrapper-inner" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-dashboard.section 
                :title="'Character'"
            >
                <x-dashboard.rank-select
                    :ranks="$ranks"
                ></x-dashboard.rank-select>
            </x-dashboard.section>
        </div>
    </div>

    {{--<ul>
    @foreach($characters as $character)
        <li><h2 class="text-lg font-bold">Character</h2> {{ $character->name }} ({{ $character->user->name }})</li>
        <li><h3 class="text-lg font-bold">Class</h3> {{ $character->class->name }}, {{ $character->class->type->name }}</li>
        <li>
            <h3 class="text-lg font-bold">Skills</h3>
            <ul class="ml-4">
                @foreach($character->skills as $skill)
                    <li>{{ $skill->name }} <em>({{ $skill->type->name }})</em></li>
                @endforeach
            </ul>
        </li>
        <li class="border-b pb-4 mb-4">
            <h3 class="text-lg font-bold">Loadout</h3>
            <ul>
                @foreach($character->loadouts as $loadout)
                    <li>
                        <ul class="ml-4">
                            --}}{{--<li>Name: {{ $loadout->name }}</li>--}}{{--
                            <li><strong>Weight:</strong> {{ $loadout->weight }}</li>
                            <li><strong>Main Hand:</strong> {{ $loadout->main->name }} <em>({{ $loadout->main->type->name }})</em></li>
                            <li><strong>Off Hand:</strong> {{ $loadout->offhand->name }} <em>({{ $loadout->offhand->type->name }})</em></li>
                        </ul>
                    </li>
                @endforeach
            </ul> 
        </li>
    @endforeach
    </ul>--}}
</x-app-layout>
