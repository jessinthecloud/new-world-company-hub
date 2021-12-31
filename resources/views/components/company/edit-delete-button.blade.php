@if( Auth::user()->can('edit companies') )
    <x-button-link href="{{ route('companies.choose') }}">
        Edit / Delete
    </x-button-link>
@endif