<x-layouts.dashboard>
    <x-dashboard.section
        :title="'Guild Bank'"
    >
    <p>Add items to the Guild Bank</p>
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
                <x-forms.label for="name" :required="true">Name:</x-forms.label>
                <x-forms.input 
                    id="name"
                    class=""
                    type="text"
                    name="name" 
                    value="{{ old('name') ?? $guildBank->name ?? '' }}"
                    :required="true" 
                />
            </x-forms.field>
            
            <x-forms.field :name="'gear_score'">
                <x-forms.label for="gear_score" :required="true">Gear Score:</x-forms.label>
                <x-forms.input 
                    id="gear_score"
                    class=""
                    type="text"
                    name="gear_score" 
                    value="{{ old('gear_score') ?? $guildBank->gear_score ?? '' }}"
                    size="10"
                    :required="true" 
                />
            </x-forms.field>

            <div class="w-full flex flex-wrap justify-start">
                <x-forms.field :name="'armor'" class="mb-6">
                    <x-forms.label for="armor" :required="true">Armor:</x-forms.label>
                    <x-forms.select name="armor" id="armor"
                        :values="$armors ?? null"
                        :required="true"
                    >{!! $armor_options ?? '' !!}</x-forms.select>
                </x-forms.field>
                
                <x-forms.field :name="'armor_type'" class="mb-6">
                    <x-forms.label for="armor_type" :required="true">Armor Type:</x-forms.label>
                    <x-forms.select name="armor_type" id="armor_type"
                        :values="$armor_types ?? null"
                        :required="true"
                    >{!! $armor_type_options ?? '' !!}</x-forms.select>
                </x-forms.field>
                
                <x-forms.field :name="'weight_class'" class="mb-6">
                    <x-forms.label for="weight_class" :required="false">Weight Class:</x-forms.label>
                    <x-forms.select name="weight_class" id="weight_class"
                        :values="$weight_classes ?? null"
                        :required="false"
                    >{!! $weight_class_options ?? '' !!}</x-forms.select>
                </x-forms.field>
            </div>
            
            <div class="w-full flex flex-wrap justify-start">
                <x-forms.field :name="'weapon'" class="mb-6">
                    <x-forms.label for="weapon" :required="true">Weapon:</x-forms.label>
                    <x-forms.select name="weapon" id="weapon"
                        :values="$weapons ?? null"
                        :required="true"
                    >{!! $weapon_options ?? '' !!}</x-forms.select>
                </x-forms.field>
                
                <x-forms.field :name="'weapon_type'" class="mb-6">
                    <x-forms.label for="weapon_type" :required="true">Weapon Type:</x-forms.label>
                    <x-forms.select name="weapon_type" id="weapon_type"
                        :values="$weapon_types ?? null"
                        :required="true"
                    >{!! $weapon_type_options ?? '' !!}</x-forms.select>
                </x-forms.field>
            </div>
            
            <x-forms.field :name="'perk'" class="mb-6">
                <x-forms.label for="perk" :required="true">Perk:</x-forms.label>
                <x-forms.select name="perk" id="perk"
                    :values="$perks ?? null"
                    :required="true"
                >{!! $perk_options ?? '' !!}</x-forms.select>
            </x-forms.field>
            
            <x-forms.field :name="'perk_type'" class="mb-6 ml-4">
                <x-forms.label for="perk_type" :required="true">Perk Type:</x-forms.label>
                <x-forms.select name="perk_type" id="perk_type"
                    :values="$perk_types ?? null"
                    :required="true"
                >{!! $perk_type_options ?? '' !!}</x-forms.select>
            </x-forms.field>
            
            <x-forms.field :name="'rarity'" class="mb-6">
                <x-forms.label for="rarity" :required="true">Rarity:</x-forms.label>
                <x-forms.select name="rarity" id="rarity"
                    :values="$raritys ?? null"
                    :required="true"
                >{!! $rarity_options ?? '' !!}</x-forms.select>
            </x-forms.field>
            
            <x-forms.field :name="'tier'" class="mb-6">
                <x-forms.label for="tier" :required="false">Tier:</x-forms.label>
                <x-forms.select name="tier" id="tier"
                    :values="$tiers ?? null"
                    :required="false"
                >{!! $tier_options ?? '' !!}</x-forms.select>
            </x-forms.field>
            
            <x-slot name="button">
                <div class="w-full flex flex-wrap flex-grow justify-start">
                    <x-button>{{ $button_text }}</x-button>
                </div>
            </x-slot>
            
        </x-forms.form>
    </x-dashboard.section>
</x-layouts.dashboard>