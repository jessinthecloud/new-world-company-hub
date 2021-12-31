@if( Gate::allows('viewAny', \App\Models\Company::class) )
    <x-forms.form
        {{-- send as plain html attribute --}}
        action="{{ route('companies.find') }}"
        {{-- set the custom $method variable --}}
        {{-- (not the form method attribute) --}}
        :method="$method ?? null"
        class="w-full mx-0 mt-8"
    >
        <x-forms.field :name="'company'" class="w-full">
            <x-forms.label for="company" :required="true" class="inline-block text-lg mr-2">
                View all members for:
            </x-forms.label>
            <x-forms.select id="company" type="text" name="company" class="inline-block" 
                :required="true" 
                :values="
                    \App\Models\Company::with('faction')
                        ->orderBy('name')->get()
                        ->mapWithKeys(function($company){
                            return [$company->slug => $company->name.' ('.$company->faction->name.')'];
                        })
                        ->all()
                "
            />
        </x-forms.field>
        
        <x-slot name="button">
            <div class="flex flex-wrap">
                <x-button name="action" value="show">View All Members</x-button>
            </div>
        </x-slot>
    </x-forms.form>
@endif