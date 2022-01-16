<x-app-layout>
    <x-slot name="header">
        <x-header-title :title="'Dashboard'"/>
    </x-slot>
    
    <div class="py-12">
        <div id="wrapper-inner" class="max-w-7xl mx-auto
            sm:px-6 
            lg:px-8
        ">
        
            {{ $slot }}
            
        </div>
    </div>
</x-app-layout>
