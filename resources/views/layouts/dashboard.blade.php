<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ (isset($title) ? $title.' | ' : '') . __('Dashboard') }} 
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div id="wrapper-inner" class="max-w-7xl mx-auto flex flex-wrap sm:px-6 lg:px-8">
        
            {{ $slot }}
            
        </div>
    </div>
</x-app-layout>
