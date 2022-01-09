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
            
            {{--<x-forms.field :name="'rarity'" class="mb-6">
                <x-forms.label for="rarity" :required="true">Rarity:</x-forms.label>
                <x-forms.select name="rarity" id="rarity"
                    :values="$raritys ?? null"
                    :required="true"
                >{!! $rarity_options ?? '' !!}</x-forms.select>
            </x-forms.field>--}}
            
            <div class="buttons w-full flex flex-wrap justify-start items-center mt-4 mb-4">
                <x-button id="add-weapon" type="button" class="mb-4 mr-4">Add Weapon</x-button>
                <x-button id="add-armor" type="button" class="mb-4">Add Armor</x-button>
            </div>

            <div id="armor-field" class="w-full flex flex-wrap justify-start hidden">
                <x-forms.field :name="'armor'" class="mb-6">
                    <x-forms.label for="armor" :required="false">Armor:</x-forms.label>
                    <x-forms.select name="armor" id="armor"
                        :values="$armors ?? null"
                        :required="false"
                    >{!! $armor_options ?? '' !!}</x-forms.select>
                </x-forms.field>
                
                {{--<x-forms.field :name="'armor_type'" class="mb-6">
                    <x-forms.label for="armor_type" :required="true">Armor Type:</x-forms.label>
                    <x-forms.select name="armor_type" id="armor_type"
                        :values="$armor_types ?? null"
                        :required="true"
                    >{!! $armor_type_options ?? '' !!}</x-forms.select>
                </x-forms.field>--}}
                
                {{--<x-forms.field :name="'weight_class'" class="mb-6">
                    <x-forms.label for="weight_class" :required="false">Weight Class:</x-forms.label>
                    <x-forms.select name="weight_class" id="weight_class"
                        :values="$weight_classes ?? null"
                        :required="false"
                    >{!! $weight_class_options ?? '' !!}</x-forms.select>
                </x-forms.field>--}}
            </div>
            
            <div x-data="{perks:{}, weapon: '', fetch:false}" id="weapon-field" class="w-full flex flex-wrap justify-start hidden">
                <x-forms.field :name="'weapon'" class="mb-6">
                    <x-forms.label for="weapon" :required="false">Weapon:</x-forms.label>
                    <x-forms.select name="weapon" id="weapon"
                        :values="$weapons ?? null"
                        :required="false"
                        x-model="weapon"
                        x-on:change="fetch=true,console.log(fetch,weapon)"
                    >{!! $weapon_options ?? '' !!}</x-forms.select>
                </x-forms.field>
                
                {{--<x-forms.field :name="'weapon_type'" class="mb-6">
                    <x-forms.label for="weapon_type" :required="true">Weapon Type:</x-forms.label>
                    <x-forms.select name="weapon_type" id="weapon_type"
                        :values="$weapon_types ?? null"
                        :required="true"
                    >{!! $weapon_type_options ?? '' !!}</x-forms.select>
                </x-forms.field>--}}
                <template x-if="fetch">
                    <x-forms.field :name="'weapon-perks'" class="w-full mb-6" id="weapon-perks-field">
                        <h3>Perks:</h3>
                        <div id="weapon-perks" x-html="await getWeapon(weapon)"></div>
                    </x-forms.field>
                </template>
            </div>
            
            <h2 class="w-full mt-8 mb-6">Additional Info</h2>
            
            <x-forms.field :name="'name'" class="w-full mb-6 hidden" id="name-field">
                <x-forms.label for="name" :required="false">Name (if missing from drop down):</x-forms.label>
                <x-forms.input 
                    id="name"
                    class=""
                    type="text"
                    name="name" 
                    value="{{ old('name') ?? $guildBank->name ?? '' }}"
                    :required="false" 
                />
            </x-forms.field>
            
            {{--<x-forms.field :name="'tier'" class="mb-6">
                <x-forms.label for="tier" :required="false">Tier:</x-forms.label>
                <x-forms.select name="tier" id="tier"
                    :values="$tiers ?? null"
                    :required="false"
                >{!! $tier_options ?? '' !!}</x-forms.select>
            </x-forms.field>--}}
            
            <div class="perks">
                <h3>Perks:</h3>
                
                <div id="perk-sample" class="block w-full flex flex-wrap justify-start items-end">
                    <x-forms.field :name="'perk'" class="mb-6">
                        <x-forms.select name="perk[]" id="perk"
                            :values="$perks ?? null"
                            :required="false"
                        >{!! $perk_options ?? '' !!}</x-forms.select>
                    </x-forms.field>
                </div>
                
                <div id="appended-perks">
                    
                </div>

                <x-button id="add-perk" type="button" class="mb-4">Add Another Perk</x-button>

            </div>
            
            {{--<x-forms.field :name="'perk_type'" class="mb-6 ml-4">
                <x-forms.label for="perk_type" :required="true">Perk Type:</x-forms.label>
                <x-forms.select name="perk_type" id="perk_type"
                    :values="$perk_types ?? null"
                    :required="true"
                >{!! $perk_type_options ?? '' !!}</x-forms.select>
            </x-forms.field>--}}
            
            <div class="attributes">
                <h3>Attributes:</h3>
                
                <div id="attr-sample" class="block w-full flex flex-wrap justify-start items-end">
                    <x-forms.field :name="'attribute_amount[]'">
                        <x-forms.input
                                id="attribute_amount"
                                class=""
                                type="text"
                                name="attribute_amount[]"
                                value="{{ old('attribute_amount[]') ?? null }}"
                                size="10"
                                :required="false"
                        />
                    </x-forms.field>
                    <x-forms.field :name="'attribute'" class="mb-6">
                        <x-forms.select name="attribute[]" id="attribute"
                            :values="$attributes ?? null"
                            :required="false"
                        >{!! $attribute_options ?? '' !!}</x-forms.select>
                    </x-forms.field>
                </div>
                
                <div id="appended-attrs">
                    
                </div>

                <x-button id="add-attr" type="button" class="mb-4">Add Another Attribute</x-button>

            </div>
            <BR><BR>
            <x-slot name="button">
                <div class="w-full flex flex-wrap flex-grow justify-start mt-12">
                    <x-button>{{ $button_text }}</x-button>
                </div>
            </x-slot>
            
        </x-forms.form>
    </x-dashboard.section>
</x-layouts.dashboard>