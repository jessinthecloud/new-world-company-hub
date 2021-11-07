@props(['method', 'inputs', 'buttonText' => 'Submit', 'button'])

<x-forms.form-errors/>

<form method="POST" {{ $attributes->merge(['class' => '']) }}>

    {{-- cross-site request forgery protection --}}
    @csrf
    
    {{-- for update or destroy, set method to PUT or DELETE in the form --}}
    @isset($method)
        @method($method)
    @endisset
    
    {{-- Allow addiitonal HTML in the form,
    or allow simply sending the form fields through 
    this general slot instead of $inputs --}}
    
    {!! $slot !!}
    
    @isset($button)
        {{-- allow custom button(s) for form --}}
        {!! $button !!}
    @else
        {{-- Submit button --}}
        <x-button>
            {{ $buttonText }}
        </x-button>
    @endisset

</form>