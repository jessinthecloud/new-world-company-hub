<x-layouts.dashboard>
    <x-dashboard.section
        :title="'Company'"
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
            <x-forms.field :name="'name'">
                <x-forms.label for="name" :required="true">Name:</x-forms.label>
                <x-forms.input 
                    id="name"
                    class=""
                    type="text"
                    name="name" 
                    value="{{ old('name') ?? $company->name ?? '' }}"
                    :required="true" 
                />
            </x-forms.field>

            <x-forms.field :name="'faction'" class="mb-6">
                <x-forms.label for="faction" :required="true">Faction:</x-forms.label>
                <x-forms.select name="faction" id="faction"
                    :values="$factions ?? null"
                    :required="true"
                >{!! $faction_options ?? '' !!}</x-forms.select>
            </x-forms.field>
            
            <x-slot name="button">
                <div class="w-full flex flex-wrap flex-grow justify-start">
                    <x-button>{{ $button_text }}</x-button>
                </div>
            </x-slot>
            
        </x-forms.form>
    </x-dashboard.section>
</x-layouts.dashboard>