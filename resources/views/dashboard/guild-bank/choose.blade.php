<x-layouts.dashboard>
    <x-dashboard.section
        :title="'Guild Bank'"
    >
        <x-forms.form
            {{-- send as plain html attribute --}}
            action="{{ $form_action ?? '' }}"
            {{-- set the custom $method variable --}}
            {{-- (not the form method attribute) --}}
            :method="$method ?? null"
        >

            @if($action == 'edit-item-type')
                <x-forms.field :name="'itemType'">
                    <x-forms.label for="itemType" :required="true">Choose:</x-forms.label>
                    <x-forms.select id="itemType" type="text" name="itemType" class="" :required="true" :values="$itemTypes"/>
                </x-forms.field>
            @elseif($action == 'edit-item')
                @empty($items)
                    <p>No {{ Str::title($itemType) }} to edit.</p>
                @else
                    <x-forms.field :name="'item'">
                        <x-forms.label for="item" :required="true">Choose:</x-forms.label>
                        <x-forms.select id="item" type="text" name="item" class="" :required="true" :values="$items"/>
                        <input type="hidden" name="itemType" value="{{ $itemType }}">
                        <input type="hidden" name="guildBank" value="{{ $guildBank }}">
                    </x-forms.field>
                @endempty
            @elseif($action == 'destroy')
                <x-forms.field :name="'item'">
                    <x-forms.label for="item" :required="true">Choose:</x-forms.label>
                    <x-forms.select id="item" type="text" name="item" class="" :required="true" :values="$items"/>
                </x-forms.field>
            @else
                <x-forms.field :name="'guildBank'">
                    <x-forms.label for="guildBank" :required="true">Choose:</x-forms.label>
                    <x-forms.select id="guildBank" type="text" name="guildBank" class="" :required="true" :values="$guildBanks ?? null"/>
                </x-forms.field>
            @endif
            
            <x-slot name="button">
                <div class="flex flex-wrap justify-between lg:max-w-1/2 ">
                    @if($action == 'destroy') 
                        <x-button name="action" 
                            value="destroy"
                            class="bg-red-800"
                            {{--@click="confirm('Delete this item?');"--}}       
                        >
                            Delete
                        </x-button>
                    @else
                        <x-button name="action" 
                            value="{{ empty($action) ? 'submit' : $action}}"
                        >
                            {{ !empty($action) ? Str::title($action) : 'Submit' }}
                        </x-button>
                    @endif 
                </div>
            </x-slot>
            
        </x-forms.form>
    </x-dashboard.section>
</x-layouts.dashboard>
