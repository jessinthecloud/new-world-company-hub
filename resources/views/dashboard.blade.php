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
                <x-forms.form
                    {{-- send as plain html attribute --}}
                    action="{{ $form_action ?? '' }}"
                    {{-- set the custom $method variable --}}
                    {{-- (not the form method attribute) --}}
                    :method="$method ?? null"
                >
                    <x-forms.field :name="'name'">
                        <x-forms.label for="name" :required="true">Name:</x-forms.label>
                        <x-forms.input id="name" type="text" name="name" class="" :required="true" value="{{ old('name') ?? '' }}"/>
                    </x-forms.field>

                    <x-forms.field :name="'level'">
                        <x-forms.label for="level" :required="true">Level:</x-forms.label>
                        <x-forms.input id="level" type="text" name="level" class="" :required="true" value="{{ old('level') ?? '' }}" />
                    </x-forms.field>

                    <x-forms.field :name="'rank'">
                        <x-forms.label for="rank" :required="true">Rank:</x-forms.label>
                        <x-forms.select name="rank" id="rank"
                            :values="$ranks"
                            :required="true"
                        ></x-forms.select>
                    </x-forms.field>

                    {{-- 
                    <x-forms.field :name="'rank'">
                        <x-forms.label for="skill">Skill:</x-forms.label>
                        <x-forms.select name="skill" id="skill"
                            :values="$skills"
                        ></x-forms.select>
                    </x-forms.field>
                    --}}
                </x-forms.form>
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
