@can('viewAny', \App\Models\Company::class)
    <x-dashboard.section
        :title="'Company'"
        class="min-w-1/3 mb-6 lg:mr-6"
    >
        <x-dashboard.view-all-button 
            :class="\App\Models\Company::class" 
            :route="route('companies.index')"
        />
        <x-dashboard.view-own-button 
            :class="\App\Models\Company::class" 
            :route="route('companies.show', ['company'=>$company])"
            :instance="$company"
        />
        <x-dashboard.create-button 
            :class="\App\Models\Company::class" 
            :route="route('companies.create')"
            :instance="$company"
        />
        <x-dashboard.edit-delete-button 
            :class="\App\Models\Company::class" 
            :route="route('companies.choose')"
            :instance="$company"
        />
    </x-dashboard.section>
@endcan
