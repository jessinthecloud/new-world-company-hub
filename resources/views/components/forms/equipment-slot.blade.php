@props([ 'title', 'name', 'type'=>null, 'subtype'=>null, 'item', 'perkOptions', 'rarityOptions', 'tierOptions', 'attributeOptions', 'existingPerkOptions'=> [], 'existingAttributeAmounts' =>[]])

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
        <livewire:item-autocomplete
                :search="isset($item) ? $item->name : ''"
                :type="$type ?? null"
                :subtype="$subtype ?? null"
                :bank="false"
                :equipSlotName="$name"
        />
    </x-forms.field>

    <x-forms.field :name="$name.'_rarity'" class="mb-6 mr-4">
        <x-forms.label for="{{ $name }}_rarity" :required="true">Rarity:</x-forms.label>
        <x-forms.select name="{{ $name }}_rarity" id="{{ $name }}_rarity"
                        :values="$raritys ?? null"
                        :required="true"
        >{!! $rarityOptions ?? '' !!}</x-forms.select>
    </x-forms.field>

    <div id="{{ $name }}-perks-attr-wrapper" class="w-full flex flex-wrap justify-start">
        <div class="perks border-r-2 border-slate-50 pr-4 mr-4">
            <h4 class="mb-1">Perks:</h4>

            @if(!empty($existingPerkOptions))
                @foreach($existingPerkOptions as $id => $options)
                    <div id="{{ $name }}-existing-perks-wrapper"
                         class="existing-perks-wrapper block w-full flex flex-wrap justify-start items-end">
                        <x-forms.field :name="$name.'_perks'" class="mb-6">
                            <x-forms.select name="{{ $name }}_perks[]" id="{{ $name }}_perks"
                                            :values="null"
                                            :required="false"
                            >{!! $options ?? '' !!}</x-forms.select>
                        </x-forms.field>
                    </div>
                @endforeach
            @endif

            <div id="{{ $name }}-perks-wrapper" class="perks-wrapper block w-full flex flex-wrap justify-start items-end">
                <x-forms.field :name="$name.'_perks'" class="mb-6">
                    <x-forms.select name="{{ $name }}_perks[]" id="{{ $name }}_perks"
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
                @foreach($existingAttributeOptions as $id => $options)
                    <div id="{{ $name }}-existing-attr-wrapper" class="block w-full flex flex-wrap justify-start items-end">
                        <x-forms.field :name="$name.'_attribute_amounts[]'">
                            <x-forms.input
                                    id="{{ $name }}_attribute_amounts"
                                    class=""
                                    type="text"
                                    name="{{ $name }}_attribute_amounts[]"
                                    value="{{ $existingAttributeAmounts[$id] }}"
                                    size="10"
                                    :required="false"
                                    placeholder="Amount"
                            />
                        </x-forms.field>
                        <x-forms.field :name="$name.'_attrs'" class="mb-6">
                            <x-forms.select
                                    name="{{ $name }}_attrs[]"
                                    id="{{ $name }}_attrs"
                                    :values="$attrs ?? null"
                                    :required="false"
                            >{!! $options ?? '' !!}</x-forms.select>
                        </x-forms.field>
                    </div>
                @endforeach
            @endif

            <div id="{{ $name }}-attr-wrapper" class="attr-wrapper block w-full flex flex-wrap justify-start items-end">
                <x-forms.field :name="$name.'_attribute_amounts[]'">
                    <x-forms.input
                            id="{{ $name }}_attribute_amounts"
                            class=""
                            type="text"
                            name="{{ $name }}_attribute_amounts[]"
                            value="{{ old($name.'_attribute_amounts[]') ?? null }}"
                            size="10"
                            :required="false"
                            placeholder="Amount"
                    />
                </x-forms.field>
                <x-forms.field :name="$name.'_attrs'" class="mb-6">
                    <x-forms.select name="{{ $name }}_attrs[]" id="{{ $name }}_attrs"
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

    <input id="{{ $name }}-base-model-id" type="hidden" name="{{ $name }}_base_id"
           value="{{ isset($item) && isset($item->base) ? $item->base->id : '' }}"/>
    <input id="{{ $name }}-base-model-slug" type="hidden" name="{{ $name }}_base_slug"
           value="{{ isset($item) && isset($item->base) ? $item->base->slug : '' }}"/>
    <input id="{{ $name }}-model-id" type="hidden" name="{{ $name }}_id" value="{{ isset($item) ? $item->id : '' }}"/>
    <input type="hidden" name="{{ $name }}_slug" value="{{ isset($item) ? $item->slug : '' }}"/>
    <input id="{{ $name }}-itemType" type="hidden" name="{{ $name }}_itemType" value="{{ $itemType ?? '' }}"/>

</div>