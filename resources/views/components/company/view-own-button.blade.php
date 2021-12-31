@if( Gate::allows(
    'view', 
    \App\Models\Company::find(Auth::user()->characters->first()->company->id)
))
    <x-button-link href="{{ route('companies.show', [
        'company', \App\Models\Company::find(Auth::user()->characters->first()->company->slug)
    ]) }}">
        View My Company
    </x-button-link>
@endif