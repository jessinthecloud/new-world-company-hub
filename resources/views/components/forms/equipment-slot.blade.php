@props([ 'title', 'name', 'required'=>false, 'type'=>null, 'subtype'=>null, 'item', 'perkOptions', 'raritys', 'tierOptions', 'attributeOptions', 'existingPerkOptions'=> [], 'existingAttributeOptions'=> [], 'existingAttributeAmounts' =>[]])

<div class="equipment-slot w-full flex flex-wrap justify-start border rounded-md p-6 mt-6 mb-6">
    <h2 class="w-full mb-6">{{ $title }}</h2>

    <x-forms.field :name="'gear_score_'.$name" class="mb-6 mr-4">
        <x-forms.label for="gear_score_{{$name}}" :required="$required">Gear Score:</x-forms.label>
        <x-forms.input
                id="gear_score_{{$name}}"
                class=""
                type="text"
                name="gear_score[{{$name}}]"
                value="{{ old('gear_score')[$name] ?? (isset($item) ? $item->gear_score : '') }}"
                size="10"
                :required="$required"
        />
    </x-forms.field>

    <x-forms.field :name="'item_name_'.$name" class="mb-6 w-3/4 lg:w-1/2">
        <x-forms.label for="item_name_{{$name}}" :required="$required">Item:</x-forms.label>
        <livewire:item-autocomplete
                :search="old($name) ?? (isset($item) ? $item->name : '')"
                :type="$type ?? null"
                :subtype="$subtype ?? null"
                :bank="false"
                :equipSlotName="$name"
        />
    </x-forms.field>

    <x-forms.field :name="'rarity-'.$name" class="mb-6 mr-4">
        <x-forms.label for="rarity-{{$name}}" :required="$required">Rarity:</x-forms.label>
        <x-forms.select name="rarity[{{$name}}]" id="rarity-{{$name}}"
                        :values="$raritys ?? null"
                        :index="$name"
                        :required="$required"
        ></x-forms.select>
    </x-forms.field>

    <div id="{{ $name }}-perks-attr-wrapper" class="w-full flex flex-wrap justify-start">
        <div class="perks border-r-2 border-slate-50 pr-4 mr-4">
            <h4 class="mb-1">Perks:</h4>

            @if(!empty($existingPerkOptions))
                @foreach($existingPerkOptions as $options)
                    <div id="{{ $name }}-existing-perks-wrapper"
                         class="existing-perks-wrapper block w-full flex flex-wrap justify-start items-end">
                        <x-forms.field :name="'perks-'.$name" class="mb-6">
                            <x-forms.select name="perks[{{$name}}][]" id="perks-{{$name}}"
                                            :values="null"
                                            :required="false"
                            >{!! $options ?? '' !!}</x-forms.select>
                        </x-forms.field>
                    </div>
                @endforeach
            @endif

            <div id="{{ $name }}-perks-wrapper" class="perks-wrapper block w-full flex flex-wrap justify-start items-end">
                <x-forms.field :name="'perks-'.$name" class="mb-6">
                    <x-forms.select name="perks[{{$name}}][]" id="perks-{{$name}}"
                                    :values="$perks ?? null"
                                    :required="false"
                    >{!! $perkOptions ?? '' !!}</x-forms.select>
                </x-forms.field>
            </div>

            <div id="{{ $name }}-appended-perks" class="appended-perks">

            </div>

            <x-button id="{{ $name }}-add-perk" type="button" class="add-perk mb-4">Add Another Perk</x-button>

        </div>

        <div class="attributes ml-4">
            <h4 class="mb-1">Attributes:</h4>

            @if(!empty($existingAttributeOptions))
                @foreach($existingAttributeOptions as $index => $options)
                    <div id="{{ $name }}-existing-attr-wrapper" class="block w-full flex flex-wrap justify-start items-end">
                        <x-forms.field :name="'attribute_amounts_'.$name">
                            <x-forms.input
                                    id="attribute_amounts_{{$name}}"
                                    class=""
                                    type="text"
                                    name="attribute_amounts[{{$name}}][]"
                                    value="{{ $existingAttributeAmounts[$index] }}"
                                    size="10"
                                    :required="false"
                                    placeholder="Amount"
                            />
                        </x-forms.field>
                        <x-forms.field :name="'attrs-'.$name" class="mb-6">
                            <x-forms.select
                                    name="attrs[{{$name}}][]"
                                    id="attrs-{{$name}}"
                                    :values="$attrs ?? null"
                                    :required="false"
                            >{!! $options ?? '' !!}</x-forms.select>
                        </x-forms.field>
                    </div>
                @endforeach
            @endif
            
            <div id="{{ $name }}-attr-wrapper" class="attr-wrapper block w-full flex flex-wrap justify-start items-end">
                <x-forms.field :name="'attribute_amounts_'.$name">
                    <x-forms.input
                            id="attribute_amounts_{{$name}}"
                            class=""
                            type="text"
                            name="attribute_amounts[{{$name}}][]"
                            value=""
                            size="10"
                            :required="false"
                            placeholder="Amount"
                    />
                </x-forms.field>
                <x-forms.field :name="'attrs-'.$name" class="mb-6">
                    <x-forms.select name="attrs[{{$name}}][]" id="attrs"
                                    :values="$attrs ?? null"
                                    :required="false"
                    >{!! $attributeOptions ?? '' !!}</x-forms.select>
                </x-forms.field>
            </div>

            <div id="{{ $name }}-appended-attrs" class="appended-attrs">

            </div>

            <x-button id="{{ $name }}-add-attr" type="button" class="add-attr mb-4">Add Another Attribute</x-button>

        </div>

    </div>
    <!-- end perks-attr-wrapper -->
    
    <input type="hidden" name="equipment_slot_names[]" value="{{ $name }}"/>

    <input id="{{ $name }}-base-model-id" type="hidden" 
        name="base_id[{{$name}}]"
        value="{{ old('base_id')[$name] ?? ((isset($item) && isset($item->base)) ? $item->base->id : '') }}"
    />
    <input id="{{ $name }}-base-model-slug" type="hidden" 
        name="base_slug[{{$name}}]"
        value="{{ old('base_slug')[$name] ?? ((isset($item) && isset($item->base)) ? $item->base->slug : '') }}"
    />
    <input id="{{ $name }}-model-id" type="hidden" 
        name="id[{{$name}}]" 
        value="{{ old('id')[$name] ?? (isset($item) ? $item->id : '') }}"
    />
    <input type="hidden" 
        name="slug" 
        value="{{ old('slug')[$name] ?? (isset($item) ? $item->slug : '') }}"
    />
    <input id="{{ $name }}-itemType" type="hidden" 
        name="itemType[{{$name}}]" 
        value="{{ old('itemType')[$name] ?? $itemType ?? '' }}"
    />

</div>