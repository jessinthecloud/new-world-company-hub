<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex justify-between">
            <span>{{ (isset($title) ? $title.' | ' : '') . __('Dashboard') }}</span> 
            @if( session('character') !== null ) 
                <span id="character-heading" class="text-gray-600">
                    {{ session('character')->company->name }} 
                    <span class="text-gray-400">/</span> 
                    {{ session('character')->name }}
                </span> 
            @endif
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div id="wrapper-inner" class="max-w-7xl mx-auto grid grid-cols-1 auto-rows-min gap-4 
            sm:px-6 
            md:grid-cols-2
            lg:px-8 lg:gap-6 lg:grid-cols-3
        ">
        
            {{ $slot }}
            
        </div>
    </div>
</x-app-layout>
