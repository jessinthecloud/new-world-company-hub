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
            <x-forms.field :name="'guildBank'">
                <x-forms.label for="guildBank" :required="true">Choose:</x-forms.label>
                <x-forms.select id="guildBank" type="text" name="guildBank" class="" :required="true" :values="$guildBanks"/>
            </x-forms.field>
            
            <x-slot name="button">
                <div class="flex flex-wrap justify-between lg:max-w-1/2">
                    <x-button name="action" value="edit">Edit</x-button>
                    <x-button name="action" value="destroy" class="bg-red-800">Delete</x-button>
                </div>
            </x-slot>
            
        </x-forms.form>
    </x-dashboard.section>
</x-layouts.dashboard>
