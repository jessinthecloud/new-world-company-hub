<x-app-layout>
    <x-slot name="title">
        Companies / {{ Str::title($company->name) }}
    </x-slot>
    
    <div class="py-12">
        <div id="wrapper-inner" class="max-w-7xl mx-auto flex flex-wrap sm:px-6 lg:px-8">
            
            <x-dashboard.gated-button
                :can="['export', $company ?? null]"
                :phpClass="\App\Models\Companies\Company::class" 
                :route="route('companies.company.export', ['company'=>$company ?? null])"
                :instance="$company ?? null"
                class="mb-4"
            >
                Export to Excel
            </x-dashboard.gated-button>
        
            <div class="w-full">
                <livewire:company-table 
                    :id="null" 
                    :company="$company" 
                    :classes="$classes"
                />
            </div>
        </div>
    </div>

</x-app-layout>
