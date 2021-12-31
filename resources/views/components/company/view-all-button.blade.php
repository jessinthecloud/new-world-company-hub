@if( Gate::allows('viewAny', \App\Models\Company::class) )
    <x-button-link href="{{ route('companies.index') }}">
        View All
    </x-button-link>
@endif
