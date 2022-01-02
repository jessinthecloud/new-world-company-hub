@if( Gate::allows('create', \App\Models\Company::class) )
    <x-button-link href="{{ route('companies.create') }}">
        Create
    </x-button-link>
@endif