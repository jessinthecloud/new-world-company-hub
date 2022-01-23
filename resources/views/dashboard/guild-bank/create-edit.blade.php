<x-layouts.dashboard>
    <x-dashboard.section
        :title="'Guild Bank'"
        class="min-h-screen"
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
                
            <x-forms.field :name="'gear_score'" class="mb-6 mr-4">
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
            <x-forms.field :name="'item'" class="mb-6 w-3/4 lg:w-1/2" x-cloak x-show="!newEntry">
                <x-forms.label for="item" :required="false">Item:</x-forms.label>
                {{--<livewire:item-drop-down/>--}}
                <livewire:item-autocomplete/>
            </x-forms.field>
            
            <x-forms.field :name="'rarity'" class="mb-6 mr-4" x-cloak x-show="!newEntry">
                <x-forms.label for="rarity" :required="true">Rarity:</x-forms.label>
                <x-forms.select name="rarity" id="rarity"
                    :values="$raritys ?? null"
                    :required="true"
                >{!! $rarity_options ?? '' !!}</x-forms.select>
            </x-forms.field>
            
            <div class="flex items-center" x-cloak x-show="!newEntry">
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
                        value="{{ old('name') ?? '' }}"
                        :required="true" 
                    />
                </x-forms.field>
                
                <x-forms.field :name="'armor_type'" class="mb-6" {{--x-show="isArmor"--}}>
                    <x-forms.label for="armor_type" :required="true">Armor Type:</x-forms.label>
                    <x-forms.select name="armor_type" id="armor_type"
                        :values="$armor_types ?? null"
                        :required="true"
                    >{!! $armor_type_options ?? '' !!}</x-forms.select>
                </x-forms.field>
                
                <x-forms.field :name="'weight_class'" class="mb-6" {{--x-show="isArmor"--}}>
                    <x-forms.label for="weight_class" :required="false">Weight Class:</x-forms.label>
                    <x-forms.select name="weight_class" id="weight_class"
                        :values="$weight_classes ?? null"
                        :required="false"
                    >{!! $weight_class_options ?? '' !!}</x-forms.select>
                </x-forms.field>
        
                <x-forms.field :name="'weapon_type'" class="mb-6" {{--x-show="isWeapon"--}}>
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
            >
                
            
            <div id="perks-attr-wrapper" class="w-full flex flex-wrap justify-start"
            >
                <div class="perks border-r-2 border-slate-50 pr-4 mr-4">
                    <h3>Perks:</h3>
                    
                     @if(!empty($existing_perk_options))
                        @foreach($existing_perk_options as $id => $options)
                            <div id="perks-wrapper" class="block w-full flex flex-wrap justify-start items-end">
                                <x-forms.field :name="'perks'" class="mb-6">
                                    <x-forms.select name="perks[]" id="perks"
                                        :values="$perks ?? null"
                                        :required="false"
                                    >{!! $options ?? '' !!}</x-forms.select>
                                </x-forms.field>
                            </div>
                        @endforeach
                    @endif
                    
                    <div id="perks-wrapper" class="block w-full flex flex-wrap justify-start items-end">
                        <x-forms.field :name="'perks'" class="mb-6">
                            <x-forms.select name="perks[]" id="perks"
                                :values="$perks ?? null"
                                :required="false"
                            >{!! $perk_options ?? '' !!}</x-forms.select>
                        </x-forms.field>
                    </div>
                    
                    <div id="appended-perks">
                        
                    </div>
    
                    <x-button id="add-perk" type="button" class="mb-4">Add Another Perk</x-button>
    
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
                    @endif
                    
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
                    
                    <div id="appended-attrs">
                        
                    </div>
    
                    <x-button id="add-attr" type="button" class="mb-4">Add Another Attribute</x-button>
    
                </div>
                
            </div> 
            <!-- end perks-attr-wrapper -->
          
            <x-forms.input type="hidden" name="is_weapon" x-bind:value="isWeapon"/>
            <x-forms.input type="hidden" name="is_armor" x-bind:value="isArmor"/>
            <input id="base-model-id" type="hidden" name="base_id" value="{{ isset($item) ? $item->id : '' }}"/>
            <input id="base-model-slug" type="hidden" name="base_slug" value="{{ isset($item) ? $item->slug : '' }}"/>
            <input id="model-id" type="hidden" name="id" value="{{ isset($item) ? $item->id : '' }}"/>
            <input type="hidden" name="slug" value="{{ isset($item) ? $item->slug : '' }}"/>
            <input id="itemType" type="hidden" name="itemType" value="{{ $itemType ?? '' }}"/>

            <x-slot name="button">
                <x-button id="submit-button" class="mt-8">{{ $button_text }}</x-button>
            </x-slot>
            
        </x-forms.form>
    </x-dashboard.section>
</x-layouts.dashboard>