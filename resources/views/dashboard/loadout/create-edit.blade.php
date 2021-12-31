<x-layouts.dashboard>

    <x-dashboard.section
        :title="'Loadout'"
    >
        <x-forms.form
            {{-- send as plain html attribute --}}
            action="{{ $form_action ?? '' }}"
            {{-- set the custom $method variable --}}
            {{-- (not the form method attribute) --}}
            :method="$method ?? null"
            :button-text="$button_text"
            class=""
        >
            <x-forms.field :name="'character'" class="mb-6">
                <x-forms.label for="character" :required="true">Character:</x-forms.label>
                <x-forms.select name="character" id="character"
                                :values="$characters ?? null"
                                :required="true"
                >{!! $character_options ?? '' !!}</x-forms.select>
            </x-forms.field>
        
            {{--<x-forms.field :name="'name'">
                <x-forms.label for="name">Loadout Name:</x-forms.label>
                <x-forms.input 
                    id="name"
                    class=""
                    type="text"
                    name="name" 
                    value="{{ old('name') ?? $loadout->name ?? '' }}"
                    
                />
            </x-forms.field>--}}

            <x-forms.field :name="'weight'">
                <x-forms.label for="weight" :required="true">Weight:</x-forms.label>
                <x-forms.input
                    id="weight"
                    class=""
                    type="text"
                    name="weight"
                    size="10"
                    value="{{ old('weight') ?? $loadout->weight ?? '' }}"
                    :required="true"
                />
            </x-forms.field>
            
            <div class="w-full"></div>
            
            <x-forms.field :name="'main'" class="mr-4 mb-6">
                <x-forms.label for="main" :required="true">Main Hand:</x-forms.label>
                <x-forms.select name="main" id="main"
                    :values="$weapons ?? null"
                    :required="true"
                >{!! $main_options ?? '' !!}</x-forms.select>
            </x-forms.field>

            <x-forms.field :name="'offhand'" class="mb-6">
                <x-forms.label for="offhand" :required="true">Off Hand:</x-forms.label>
                <x-forms.select name="offhand" id="offhand"
                    :values="$weapons ?? null"
                    :required="true"
                >{!! $offhand_options ?? '' !!}</x-forms.select>
            </x-forms.field>
            
        </x-forms.form>
    </x-dashboard.section>
</x-layouts.dashboard>
