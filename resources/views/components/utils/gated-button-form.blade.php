@props(['route', 'can', 'routeName', 'method'=>'POST'])

@if(Route::has($routeName))
    @can(...$can)
        <x-forms.form
            action="{{  $route }}"
            :method="$method"
            {{ $attributes->merge([
                'class' => 'mt-2'
            ]) }}
        >
            <x-slot name="button">
                <x-button name="action">
                    {{ empty($slot->toHtml()) ? 'Submit' : $slot }}
                </x-button>
            </x-slot>
        </x-forms.form>
    @endcan
@endif