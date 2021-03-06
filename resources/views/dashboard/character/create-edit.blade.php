<x-layouts.dashboard>
    <x-dashboard.section
        :title="'Character'"
    >
        <x-forms.form
            {{-- send as plain html attribute --}}
            action="{{ $form_action ?? '' }}"
            {{-- set the custom $method variable --}}
            {{-- (not the form method attribute) --}}
            :method="$method ?? null"
            :button-text="$button_text"
            class="flex flex-wrap justify-start"
        >
            <x-forms.field :name="'name'">
                <x-forms.label for="name" :required="true">In-game Name:</x-forms.label>
                <x-forms.input 
                    id="name"
                    class=""
                    type="text"
                    name="name" 
                    value="{{ old('name') ?? $character->name ?? '' }}"
                    :required="true" 
                />
            </x-forms.field>
            
            @if(isset($method) && strtolower($method) == 'put')
                @if(request()->user()->can('edit company members'))
                    <x-forms.field :name="'company'" class="mb-6">
                        <x-forms.label for="company" :required="true">Company:</x-forms.label>
                        <x-forms.select name="company" id="company"
                            :values="$companies ?? null"
                            :required="true"
                        >{!! $company_options ?? '' !!}</x-forms.select>
                    </x-forms.field>
                    
                    <x-forms.field :name="'rank'" class="mb-6">
                        <x-forms.label for="rank" :required="false">Rank:</x-forms.label>
                        <x-forms.select name="rank" id="rank"
                            :values="$ranks ?? null"
                            :required="false"
                        >{!! $rank_options ?? '' !!}</x-forms.select>
                    </x-forms.field>
                @endif
    
            @endif
            
            <x-forms.field :name="'class'" class="mb-6">
                <x-forms.label for="class" :required="true">Class:</x-forms.label>
                <x-forms.select name="class" id="class"
                                :values="$classes ?? null"
                                :required="true"
                >{!! $class_options ?? '' !!}</x-forms.select>
            </x-forms.field>

            {{--<x-forms.field :name="'level'">
                <x-forms.label for="level" :required="false">Level:</x-forms.label>
                <x-forms.input
                    id="level"
                    class=""
                    type="text"
                    name="level"
                    size="10"
                    value="{{ old('level') ?? $character->level ?? '' }}"
                    :required="false"
                />
            </x-forms.field>--}}
            
            {{--<div class="character-skills border rounded-md p-6 mt-6 mb-6">
                <h3 class="mb-6">Skill Levels</h3>
                @foreach($skillTypes as $skillType)
                    <x-forms.field class="flex flex-wrap justify-start border-t pt-4">
                        <h4 class="w-full mb-4">{{ $skillType->name }}</h4>
                        @foreach($skillType->skills as $skill)
                            <x-forms.field 
                                :name="'skills['.$skill->id.']'" 
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
                                    name="{{ 'skills['.$skill->id.']' }}"
                                    value="{{ old('skill-'.$skill->id) 
                                        ?? ((isset($character) 
                                            && $character->skills->where('id', $skill->id)->first() !== null) 
                                                ? $character->skills->where('id', $skill->id)->first()->pivot->level 
                                                : null) 
                                        ?? '' }}"
                                    :required="false"
                                />
                            </x-forms.field>
                        @endforeach
                    </x-forms.field>                             
                @endforeach
            </div>--}}
            
            <x-slot name="button">
                <div class="flex flex-wrap flex-grow justify-start">
                    <x-button class="self-center">{{ $button_text }}</x-button>
                </div>
            </x-slot>
            
        </x-forms.form>
    </x-dashboard.section>
</x-layouts.dashboard>
