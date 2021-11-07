<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div id="wrapper-inner" class="max-w-7xl mx-auto flex flex-wrap sm:px-6 lg:px-8">
            
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
                        <x-forms.input id="name" type="text" name="name" class="" :required="true" value="{{ old('name') ?? $character->name ?? '' }}"/>
                    </x-forms.field>
            
                    <x-forms.field :name="'level'">
                        <x-forms.label for="level" :required="true">Level:</x-forms.label>
                        <x-forms.input id="level" type="text" name="level" size="10" :required="true" value="{{ old('level') ?? $character->level ??'' }}" />
                    </x-forms.field>
            
                    <x-forms.field :name="'rank'" class="mb-6">
                        <x-forms.label for="rank" :required="true">Rank:</x-forms.label>
                        <x-forms.select name="rank" id="rank"
                            :values="$ranks ?? null"
                            :required="true"
                        >{!! $options ?? '' !!}</x-forms.select>
                    </x-forms.field>
            
                    {{-- 
                    <x-forms.field :name="'skill'">
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
</x-app-layout>