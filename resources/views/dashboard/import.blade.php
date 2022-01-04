<x-layouts.dashboard>
    <x-dashboard.section
        :title="'Import Roster'"
    >
        <x-forms.form
            {{-- send as plain html attribute --}}
            action="{{ route('rosters.import.store') }}"
            {{-- set the custom $method variable --}}
            {{-- (not the form method attribute) --}}
            :method="$method ?? null"
            enctype="multipart/form-data"
        >
            <x-forms.field :name="'company'">
                <x-forms.label for="company" :required="true">For Company:</x-forms.label>
                <x-forms.select id="company" type="text" name="company" class="" :required="true" :values="$companies"/>
            </x-forms.field>
            
            <x-forms.field 
                :name="'import'" 
                class="flex flex-wrap justify-start items-center pr-4"
            >
                <x-forms.label 
                    for="import" 
                    class="min-w-content w-28 mr-2" 
                    :required="false"
                >
                    Roster Spreadsheet:
                </x-forms.label>
                <x-forms.input 
                    id="import"
                    class=""
                    type="file"
                    name="import"
                    value="{{ old('import') }}"
                    :required="false"
                />
            </x-forms.field>
            
            <x-slot name="button">
                <div class="flex flex-wrap flex-grow justify-start">
                    <x-button>Import</x-button>
                </div>
            </x-slot>
        </x-forms.form>
    </x-dashboard.section>
</x-layouts.dashboard>