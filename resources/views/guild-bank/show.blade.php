<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
    @if(!empty(session('status')))
    <!-- Session Status -->
        <x-auth-session-status class="mb-6" :status="session('status')" />
    @endif
    
    <div class="py-12">
        <div id="wrapper-inner" class="max-w-7xl mx-auto flex flex-wrap sm:px-6 lg:px-8">
            <livewire:guild-bank-table 
                :id="null"
                :company="$company"
                :weapons="$weapons"
                :armors="$armors"
                :weight_class="$weight_class"
                :types="$types"
            />
            {{--<livewire:weapon-bank-table 
                :id="null"
                :guildBank="$guildBank"
                :weapons="$weapons"
            />--}}
        </div>
    </div>

</x-app-layout>