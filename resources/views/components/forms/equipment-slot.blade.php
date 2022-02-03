@props([ 'title', 'name', 'item', 'perkOptions', 'rarityOptions', 'tierOptions', 'attributeOptions', 'existingPerkOptions'=> [], 'existingAttributeAmounts' =>[]])

{{-- TODO: ADD NAME PREFIX TO ALL FIELDS --}}

<div class="equipment-slot w-full flex flex-wrap justify-start border rounded-md p-6 mt-6 mb-6">
    <h2 class="w-full mb-6">{{ $title }}</h2>
    
    <x-forms.field :name="$name.'_gear_score'" class="mb-6 mr-4">
        <x-forms.label for="{{ $name }}_gear_score" :required="true">Gear Score:</x-forms.label>
        <x-forms.input 
            id="{{ $name }}_gear_score"
            class=""
            type="text"
            name="{{ $name }}_gear_score" 
            value="{{ old($name.'_gear_score') ?? (isset($item) ? $item->gear_score : '') }}"
            size="10"
            :required="true" 
        />
    </x-forms.field>
    
    <x-forms.field :name="$name" class="mb-6 w-3/4 lg:w-1/2">
        <x-forms.label for="{{ $name }}" :required="true">Item:</x-forms.label>
        <livewire:item-autocomplete :search="isset($item) ? $item->name : ''"/>
    </x-forms.field>
    
    <x-forms.field :name="'rarity'" class="mb-6 mr-4" x-cloak x-show="!newEntry">
        <x-forms.label for="rarity" :required="true">Rarity:</x-forms.label>
        <x-forms.select name="rarity" id="rarity"
            :values="$raritys ?? null"
            :required="true"
        >{!! $rarityOptions ?? '' !!}</x-forms.select>
    </x-forms.field>
    
    <div id="perks-attr-wrapper" class="w-full flex flex-wrap justify-start">
        <div class="perks border-r-2 border-slate-50 pr-4 mr-4">
            <h3>Perks:</h3>
            
             @if(!empty($existingPerkOptions))
                @foreach($existingPerkOptions as $id => $options)
                    <div id="perks-wrapper" class="block w-full flex flex-wrap justify-start items-end">
                        <x-forms.field :name="'perks'" class="mb-6">
                            <x-forms.select name="perks[]" id="perks"
                                :values="null"
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
                    >{!! $perkOptions ?? '' !!}</x-forms.select>
                </x-forms.field>
            </div>
            
            <div id="appended-perks">
                
            </div>

            <x-button id="add-perk" type="button" class="mb-4">Add Another Perk</x-button>

        </div>
        
        <div class="attributes ml-4">
            <h3>Attributes:</h3>
            
            @if(!empty($existingAttributeOptions))
                @foreach($existingAttributeOptions as $id => $options)
                    <div id="attr-wrapper" class="block w-full flex flex-wrap justify-start items-end">
                        <x-forms.field :name="'attribute_amounts[]'">
                            <x-forms.input
                                id="attribute_amounts"
                                class=""
                                type="text"
                                name="attribute_amounts[]"
                                value="{{ $existingAttributeAmounts[$id] }}"
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
                    >{!! $attributeOptions ?? '' !!}</x-forms.select>
                </x-forms.field>
            </div>
            
            <div id="appended-attrs">
                
            </div>

            <x-button id="add-attr" type="button" class="mb-4">Add Another Attribute</x-button>

        </div>
        
    </div> 
    <!-- end perks-attr-wrapper -->
    
    <input id="base-model-id" type="hidden" name="base_id" value="{{ isset($item) && isset($item->base) ? $item->base->id : '' }}"/>
    <input id="base-model-slug" type="hidden" name="base_slug" value="{{ isset($item) && isset($item->base) ? $item->base->slug : '' }}"/>
    <input id="model-id" type="hidden" name="id" value="{{ isset($item) ? $item->id : '' }}"/>
    <input type="hidden" name="slug" value="{{ isset($item) ? $item->slug : '' }}"/>
    <input id="itemType" type="hidden" name="itemType" value="{{ $itemType ?? '' }}"/>
    
</div>