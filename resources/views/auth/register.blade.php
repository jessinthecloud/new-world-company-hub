<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>
        
        <!-- Validation Errors -->
        <x-forms.form-errors class="w-full sm:max-w-md"/>
        
        @if (Route::has('discord.redirect'))
            <x-utils.card>
                <div class="flex flex-wrap items-center justify-center">
                    <x-button-link class="block bg-indigo-500 ml-3" href="{{ route('discord.redirect') }}">
                        {{ __('Register with Discord') }}
                    </x-button-link>
                </div>
            </x-utils.card>

            <div class="flex flex-wrap items-center justify-center mt-6">
                - OR -
            </div>
        @endif

        <x-utils.card>    
            <form method="POST" action="{{ route('register') }}">
                @csrf
    
                <!-- Name -->
                <div>
                    <x-forms.label for="name" :value="__('Name')" />
    
                    <x-forms.input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                </div>
    
                <!-- Email Address -->
                <div class="mt-4">
                    <x-forms.label for="email" :value="__('Email')" />
    
                    <x-forms.input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                </div>
    
                <!-- Password -->
                <div class="mt-4">
                    <x-forms.label for="password" :value="__('Password')" />
    
                    <x-forms.input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />
                </div>
    
                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-forms.label for="password_confirmation" :value="__('Confirm Password')" />
    
                    <x-forms.input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required />
                </div>
    
                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
    
                    <x-button class="ml-4">
                        {{ __('Register') }}
                    </x-button>
                </div>
            </form>
        </x-utils.card>
    </x-auth-card>
</x-guest-layout>
