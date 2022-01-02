<x-layouts.dashboard>
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
                    <x-button name="action" value="{{ Str::slug($action) }}">{{ Str::title($action) }}</x-button>
                </div>
            </x-slot>
            
        </x-forms.form>
    </x-dashboard.section>
</x-layouts.dashboard>
