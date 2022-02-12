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
                @if($method=='DELETE')
                    <x-button name="action" class="bg-red-600">
                        {{ empty($slot->toHtml()) ? 'Submit' : $slot }}
                    </x-button>
                @else 
                    <x-button name="action">
                        {{ empty($slot->toHtml()) ? 'Submit' : $slot }}
                    </x-button>
                @endif 
            </x-slot>
        </x-forms.form>
    @endcan
@endif