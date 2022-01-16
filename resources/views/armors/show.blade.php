<x-app-layout>
    <x-slot name="title">
        Armor / {{ Str::title($armor->name) }}
    </x-slot>
    
    @if(!empty(session('status')))
    <!-- Session Status -->
        <x-auth-session-status class="mb-6" :status="session('status')" />
    @endif
    
    <div class="py-12">
        <div id="wrapper-inner" class="max-w-7xl mx-auto flex flex-wrap sm:px-6 lg:px-8">
            <?php dump($armor); ?>
        </div>
    </div>

</x-app-layout>
