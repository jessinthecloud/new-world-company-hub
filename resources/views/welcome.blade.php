<x-guest-layout>
    <x-slot name="header">
        <x-header-title :title="'Welcome'"/>
    </x-slot>
    
    <div class="py-12">
        <div id="wrapper-inner" class="max-w-7xl mx-auto
            sm:px-6 
            lg:px-8
        ">
        
        {{-- Character --}}
        <x-dashboard.resource-index
            :title="'Character'"
            :phpClass="\App\Models\Characters\Character::class" 
            :entityName="'character'"
            :pluralEntityName="'characters'"
            :instance="$character ?? null"
        />
            
        </div>
    </div>
</x-guest-layout>