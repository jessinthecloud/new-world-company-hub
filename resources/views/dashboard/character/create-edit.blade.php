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
                    class="flex flex-wrap"
                >
                    <x-forms.field :name="'name'">
                        <x-forms.label for="name" :required="true">Name:</x-forms.label>
                        <x-forms.input 
                            id="name"
                            class=""
                            type="text"
                            name="name" 
                            value="{{ old('name') ?? $character->name ?? '' }}"
                            :required="true" 
                        />
                    </x-forms.field>
                    
                    <x-forms.field :name="'rank'" class="mb-6">
                        <x-forms.label for="rank" :required="true">Rank:</x-forms.label>
                        <x-forms.select name="rank" id="rank"
                            :values="$ranks ?? null"
                            :required="true"
                        >{!! $rank_options ?? '' !!}</x-forms.select>
                    </x-forms.field>
                    
                    <x-forms.field :name="'level'">
                        <x-forms.label for="level" :required="true">Level:</x-forms.label>
                        <x-forms.input
                                id="level"
                                class=""
                                type="text"
                                name="level"
                                size="10"
                                value="{{ old('level') ?? $character->level ??'' }}"
                                :required="true"
                        />
                    </x-forms.field>

                    <x-forms.field :name="'class'" class="mb-6">
                        <x-forms.label for="class" :required="true">Class:</x-forms.label>
                        <x-forms.select name="class" id="class"
                                        :values="$classes ?? null"
                                        :required="true"
                        >{!! $class_options ?? '' !!}</x-forms.select>
                    </x-forms.field>
                    
                    <div class="character-skills border rounded-md p-6 mt-6">
                        <h3 class="mb-6">Skills</h3>
                        @foreach($skillTypes as $skillType)
                            <x-forms.field class="flex flex-wrap justify-start border-t pt-4">
                                <h4 class="w-full mb-4">{{ $skillType->name }}</h4>
                                @foreach($skillType->skills as $skill)
                                    <x-forms.field 
                                        :name="'skill['.$skill->id.']'" 
                                        class="flex flex-wrap justify-start items-center w-1/4 pr-4"
                                    >
                                        <x-forms.label 
                                            for="{{ 'skill-'.$skill->id }}" 
                                            class="min-w-content w-28 mr-2 text-right" 
                                            :required="false"
                                        >
                                            {{ $skill->name }}:
                                        </x-forms.label>
                                        <x-forms.input 
                                            id="{{ 'skill-'.$skill->id }}"
                                            class=""
                                            size="5"
                                            type="text"
                                            name="{{ 'skill['.$skill->id.']' }}"
                                            value="{{ old('skill-'.$skill->id) 
                                                ?? ((isset($character) 
                                                    && $character->skills->where('id', $skill->id)->first() !== null) 
                                                        ? $character->skills->where('id', $skill->id)->first()->pivot->level 
                                                        : null) 
                                                ?? 0 }}"
                                            :required="false"
                                        />
                                    </x-forms.field>
                                @endforeach
                            </x-forms.field>                             
                        @endforeach
                    </div>
                </x-forms.form>
            </x-dashboard.section>
        </div>
    </div>
</x-app-layout>