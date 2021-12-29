<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>
        
        @if(!empty(session('status')))
            <x-utils.card>
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
            </x-utils.card>
        @endif
        
        <x-utils.card>
            <div class="flex flex-wrap items-center justify-center">
                <x-button-link class="block bg-indigo-500 ml-3" href="{{ route('discord.redirect') }}">
                    {{ __('Login with Discord') }}
                </x-button-link>
            </div>
        </x-utils.card>

    </x-auth-card>
</x-guest-layout>
