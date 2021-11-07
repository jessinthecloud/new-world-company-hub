<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div id="wrapper-inner" class="max-w-7xl mx-auto flex flex-wrap sm:px-6 lg:px-8">
            
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
        </div>
    </div>
</x-app-layout>