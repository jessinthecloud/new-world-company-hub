<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div id="wrapper-inner" class="max-w-7xl mx-auto flex flex-wrap sm:px-6 lg:px-8">

            <x-dashboard.section
                :title="'Character'"
            >
                <x-forms.form
                    {{-- send as plain html attribute --}}
                    action="{{ $form_action ?? '' }}"
                    {{-- set the custom $method variable --}}
                    {{-- (not the form method attribute) --}}
                    :method="$method ?? null"
                >
                    <x-forms.field :name="'character'">
                        <x-forms.label for="character" :required="true">Choose:</x-forms.label>
                        <x-forms.select id="character" type="text" name="character" class="" :required="true" :values="$characters"/>
                    </x-forms.field>
                    
                    <x-slot name="button">
                        <div class="flex flex-wrap justify-between lg:max-w-1/2">
                            <x-button name="action" value="edit">Edit</x-button>
                            <x-button name="action" value="destroy" class="bg-red-800">Delete</x-button>
                        </div>
                    </x-slot>
                    
                </x-forms.form>
            </x-dashboard.section>
        </div>
    </div>
</x-app-layout>