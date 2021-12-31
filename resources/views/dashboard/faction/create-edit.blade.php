<x-layouts.dashboard>
   
    <x-dashboard.section
        :title="'Faction'"
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
                    value="{{ old('name') ?? $faction->name ?? '' }}"
                    :required="true" 
                />
            </x-forms.field>
            
            <x-slot name="button">
                <div class="w-full flex flex-wrap flex-grow justify-start">
                    <x-button>{{ $button_text }}</x-button>
                </div>
            </x-slot>
            
        </x-forms.form>
    </x-dashboard.section>
</x-layouts.dashboard>
