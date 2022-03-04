<x-layouts.dashboard>
    <x-dashboard.section
        :title="'Guild Bank'"
        class="min-h-screen"
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
                <livewire:item-autocomplete :search="isset($item) ? $item->name : ''"/>
            </x-forms.field>
            
            <x-forms.field :name="'rarity'" class="mb-6 mr-4" x-cloak x-show="!newEntry">
                <x-forms.label for="rarity" :required="true">Rarity:</x-forms.label>
                <x-forms.select name="rarity" id="rarity"
                    :values="$raritys ?? null"
                    :required="true"
                >{!! $rarity_options ?? '' !!}</x-forms.select>
            </x-forms.field>
            
            <div id="perks-attr-wrapper" class="w-full flex flex-wrap justify-start">
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
                    
                    <div id="perks-wrapper" class="perks-wrapper block w-full flex flex-wrap justify-start items-end">
                        <x-forms.field :name="'perks'" class="mb-6">
                            <x-forms.select name="perks[]" id="perks"
                                :values="$perks ?? null"
                                :required="false"
                            >{!! $perk_options ?? '' !!}</x-forms.select>
                        </x-forms.field>
                    </div>
                    
                    <div id="appended-perks" class="appended-perks">
                        
                    </div>
    
                    <x-button id="add-perk" type="button" class="add-perk mb-4">Add Another Perk</x-button>
    
                </div>
                
            </div> 
            <!-- end perks-attr-wrapper -->
                
            <input id="base-model-id" type="hidden" name="base_id" value="{{ isset($item) && isset($item->base) ? $item->base->id : '' }}"/>
            <input id="base-model-slug" type="hidden" name="base_slug" value="{{ isset($item) && isset($item->base) ? $item->base->slug : '' }}"/>
            <input id="model-id" type="hidden" name="id" value="{{ isset($item) ? $item->id : '' }}"/>
            <input id="model-slug" type="hidden" name="slug" value="{{ isset($item) ? $item->slug : '' }}"/>
            <input id="itemType" type="hidden" name="itemType" value="{{ $itemType ?? '' }}"/>

            <x-slot name="button">
                <x-button id="submit-button" class="mt-8">{{ $button_text }}</x-button>
            </x-slot>
            
        </x-forms.form>
    </x-dashboard.section>
</x-layouts.dashboard>