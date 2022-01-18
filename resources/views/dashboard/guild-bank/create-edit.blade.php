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
            
             x-data="{weapons: {}, armors: {}, isWeapon:{{ $isWeapon ?? 0 }}, isArmor:{{ $isArmor ?? 0 }}, newEntry:{{ $newEntry ?? 0 }}, fetch:false}"
        >
            <div class="buttons w-full flex flex-wrap justify-start items-center mt-4 mb-4" x-show="!isWeapon && !isArmor">
                <x-button 
                    id="add-weapon" type="button" class="mb-4 mr-4"
                    @click="isWeapon=1, console.log(isWeapon) {{--, weapons = await getItems('base-weapons')--}}"
                >
                    Add Weapon
                </x-button>
                <x-button 
                    id="add-armor" type="button" class="mb-4"
                    @click="isArmor=1"
                >
                    Add Armor
                </x-button>
            </div>
                
            <x-forms.field :name="'weapon_gear_score'" class="mb-6 mr-4" x-cloak x-show="isWeapon && !newEntry">
                <x-forms.label for="weapon_gear_score" :required="true">Gear Score:</x-forms.label>
                <x-forms.input 
                    id="weapon_gear_score"
                    class=""
                    type="text"
                    name="weapon_gear_score" 
                    value="{{ old('weapon_gear_score') ?? (isset($item) ? $item->gear_score : '') }}"
                    size="10"
                    :required="true" 
                />
            </x-forms.field>
            <x-forms.field :name="'weapon'" class="mb-6" x-cloak x-show="isWeapon && !newEntry">
                <x-forms.label for="weapon" :required="false">Weapon:</x-forms.label>
                <x-forms.select name="weapon" id="weapon"
                    :values="$weapons ?? null"
                    :required="false"
                >{!! $base_weapon_options ?? '' !!}</x-forms.select>
            </x-forms.field>
            
            <x-forms.field :name="'armor_gear_score'" class="mb-6 mr-4" x-cloak x-show="isArmor && !newEntry">
                <x-forms.label for="armor_gear_score" :required="true">Gear Score:</x-forms.label>
                <x-forms.input 
                    id="armor_gear_score"
                    class=""
                    type="text"
                    name="armor_gear_score" 
                    value="{{ old('armor_gear_score') ?? (isset($item) ? $item->gear_score : '') }}"
                    size="10"
                    :required="true" 
                />
            </x-forms.field>
            <x-forms.field :name="'armor'" class="mb-6" x-cloak x-show="isArmor && !newEntry">
                <x-forms.label for="armor" :required="false">Armor:</x-forms.label>
                <x-forms.select name="armor" id="armor"
                    :values="$armors ?? null"
                    :required="false"
                >{!! $base_armor_options ?? '' !!}</x-forms.select>
            </x-forms.field>   
            
            <x-forms.field :name="'rarity'" class="mb-6 mr-4" x-cloak x-show="(isArmor || isWeapon) && !newEntry">
                <x-forms.label for="rarity" :required="true">Rarity:</x-forms.label>
                <x-forms.select name="rarity" id="rarity"
                    :values="$raritys ?? null"
                    :required="true"
                >{!! $rarity_options ?? '' !!}</x-forms.select>
            </x-forms.field>
            
            <div class="flex items-center" x-cloak x-show="(isWeapon || isArmor) && !newEntry">
                <x-button type="button" class="mb-6 bg-red-200 text-gray-700 hover:text-gray-100 hover:bg-red-500"
                    @click="newEntry=true"
                >
                    My item isn't listed
                </x-button>
            </div>
            
            <div id="new-entry" class="w-full flex flex-wrap justify-start my-6" 
                x-cloak x-show="newEntry"
            >
                <x-forms.field :name="'name'" class="mb-6" id="name-field">
                    <x-forms.label for="name" :required="true">Name:</x-forms.label>
                    <x-forms.input 
                        id="name"
                        class=""
                        type="text"
                        name="name" 
                        value="{{ old('name') ?? (isset($item) ? $item->name : '') }}"
                        :required="true" 
                    />
                </x-forms.field>
                
                <x-forms.field :name="'gear_score'" class="mb-6">
                    <x-forms.label for="gear_score" :required="true">Gear Score:</x-forms.label>
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
                
                <x-forms.field :name="'armor_type'" class="mb-6" x-show="isArmor">
                    <x-forms.label for="armor_type" :required="true">Armor Type:</x-forms.label>
                    <x-forms.select name="armor_type" id="armor_type"
                        :values="$armor_types ?? null"
                        :required="true"
                    >{!! $armor_type_options ?? '' !!}</x-forms.select>
                </x-forms.field>
                
                <x-forms.field :name="'weight_class'" class="mb-6" x-show="isArmor">
                    <x-forms.label for="weight_class" :required="false">Weight Class:</x-forms.label>
                    <x-forms.select name="weight_class" id="weight_class"
                        :values="$weight_classes ?? null"
                        :required="false"
                    >{!! $weight_class_options ?? '' !!}</x-forms.select>
                </x-forms.field>
        
                <x-forms.field :name="'weapon_type'" class="mb-6" x-show="isWeapon">
                    <x-forms.label for="weapon_type" :required="true">Weapon Type:</x-forms.label>
                    <x-forms.select name="weapon_type" id="weapon_type"
                        :values="$weapon_types ?? null"
                        :required="true"
                    >{!! $weapon_type_options ?? '' !!}</x-forms.select>
                </x-forms.field>
                
                <x-forms.field :name="'custom_rarity'" class="mb-6 mr-4">
                    <x-forms.label for="custom-rarity" :required="true">Rarity:</x-forms.label>
                    <x-forms.select name="custom_rarity" id="custom-rarity"
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
            </div> <!-- end new entry -->
            
            <div id="perks-attr-wrapper" class="w-full flex flex-wrap justify-start"
                x-cloak x-show="isWeapon || isArmor"
            >
                <div class="perks border-r-2 border-slate-50 pr-4 mr-4">
                    <h3>Perks:</h3>
                    
                    <div id="perks-wrapper" class="block w-full flex flex-wrap justify-start items-end">
                        <x-forms.field :name="'perks'" class="mb-6">
                            <x-forms.select name="perks[]" id="perks"
                                :values="$perks ?? null"
                                :required="false"
                                :multiple="true"
                                size="15"
                            >{!! $perk_options ?? '' !!}</x-forms.select>
                        </x-forms.field>
                    </div>
    
                </div>
                
                <div class="attributes ml-4">
                    <h3>Attributes:</h3>
                    
                    @if(!empty($existing_attribute_options))
                        @foreach($existing_attribute_options as $id => $options)
                            <div id="attr-wrapper" class="block w-full flex flex-wrap justify-start items-end">
                                <x-forms.field :name="'attribute_amounts[]'">
                                    <x-forms.input
                                        id="attribute_amounts"
                                        class=""
                                        type="text"
                                        name="attribute_amounts[]"
                                        value="{{ $existing_attribute_amounts[$id] }}"
                                        size="10"
                                        :required="false"
                                        placeholder="Amount"
                                    />
                                </x-forms.field>
                                <x-forms.field :name="'attrs'" class="mb-6">
                                    <x-forms.select name="attrs[]" id="attrs"
                                        :values="$attrs ?? null"
                                        :required="false"
                                    >{!! $options ?? '' !!}</x-forms.select>
                                </x-forms.field>
                            </div>
                        @endforeach
                    @else
                        <div id="attr-wrapper" class="block w-full flex flex-wrap justify-start items-end">
                            <x-forms.field :name="'attribute_amounts[]'">
                                <x-forms.input
                                    id="attribute_amounts"
                                    class=""
                                    type="text"
                                    name="attribute_amounts[]"
                                    value="{{ old('attribute_amounts[]') ?? null }}"
                                    size="10"
                                    :required="false"
                                    placeholder="Amount"
                                />
                            </x-forms.field>
                            <x-forms.field :name="'attrs'" class="mb-6">
                                <x-forms.select name="attrs[]" id="attrs"
                                    :values="$attrs ?? null"
                                    :required="false"
                                >{!! $attribute_options ?? '' !!}</x-forms.select>
                            </x-forms.field>
                        </div>
                    @endif

                    
                    <div id="appended-attrs">
                        
                    </div>
    
                    <x-button id="add-attr" type="button" class="mb-4">Add Another Attribute</x-button>
    
                </div>
                
            </div> 
            <!-- end perks-attr-wrapper -->

            <x-forms.input type="hidden" name="is_weapon" x-bind:value="isWeapon"/>
            <x-forms.input type="hidden" name="is_armor" x-bind:value="isArmor"/>
            <input type="hidden" name="slug" value="{{isset($item) ? $item->slug : ''}}"/>
            <input type="hidden" name="itemType" value="{{$itemType ?? ''}}"/>

            <x-slot name="button">
                <x-button id="submit-button" class="mt-8" x-cloak x-show="isWeapon || isArmor">{{ $button_text }}</x-button>
            </x-slot>
            
        </x-forms.form>
    </x-dashboard.section>
</x-layouts.dashboard>