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
            class="flex flex-wrap justify-start"
        >
            {{--<x-forms.field :name="'character'" class="mb-6">
                <x-forms.label for="character" :required="true">Character:</x-forms.label>
                <x-forms.select name="character" id="character"
                                :values="$characters ?? null"
                                :required="true"
                >{!! $character_options ?? '' !!}</x-forms.select>
            </x-forms.field>--}}
        
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
            
            <x-forms.field :name="'gear_score'" class="mb-6 mr-4">
                <x-forms.label for="gear_score" :required="true">Character Gear Score:</x-forms.label>
                <x-forms.input 
                    id="gear_score"
                    class=""
                    type="text"
                    name="gear_score" 
                    value="{{ old('gear_score') ?? (isset($item) ? $item->gear_score : '') }}"
                    size="10"
                    :required="true" 
                />
            </x-forms.field>
            
            <x-forms.field :name="'weight'">
                <x-forms.label for="weight" :required="false">Weight:</x-forms.label>
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
            
            @foreach($equipment_slots as $name => $equipment)
                <x-forms.equipment-slot
                    :title="ucfirst($name)"
                    :name="$name"
                    :type="$equipment['type'] ?? null"
                    :subtype="$equipment['subtype'] ?? null"
                    :item="$equipment['item'] ?? null"
                    :required="$equipment['required'] ?? null"
                    :perkOptions="$perk_options"
                    :rarityOptions="$rarity_options"
                    :tierOptions="$tier_options"
                    :attributeOptions="$attribute_options"
                    :existingPerkOptions="$equipment['existing_perk_options'] ?? []"
                    :existingAttributeOptions="$equipment['existing_attribute_options'] ?? []"
                    :existingAttributeAmounts="$equipment['existing_attribute_amounts'] ?? []"
                />
            @endforeach
            
        </x-forms.form>
    </x-dashboard.section>
</x-layouts.dashboard>
