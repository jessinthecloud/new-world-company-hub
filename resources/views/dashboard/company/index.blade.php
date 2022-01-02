<x-dashboard.section
    :title="'Companies'"
    class="min-w-1/3 mb-6 lg:mr-6"
>
    <x-dashboard.view-all-button 
        :class="\App\Models\Company::class" 
        :route="route('companies.index')"
    />
    <x-dashboard.view-own-button 
        :class="\App\Models\Company::class" 
        :route="route('companies.show', ['company'=>$company])"
        :company="$company"
    />
</x-dashboard.section>
