<x-app-layout>
    <x-slot name="title">
        Weapons / {{ Str::title($weapon->name) }}
    </x-slot>
    
    @if(!empty(session('status')))
    <!-- Session Status -->
        <x-auth-session-status class="mb-6" :status="session('status')" />
    @endif
    
    <div class="py-12">
        <div id="wrapper-inner" class="max-w-7xl mx-auto flex flex-wrap sm:px-6 lg:px-8">
<!--            --><?php //dump($weapon); ?>
            <h1 class="w-full"> {{ $weapon->gear_score }} -- {{ $weapon->name }}</h1>
            <div class="w-1/2">
                <h2 class="w-full">Perks</h2>
                <ul>
                    @foreach($weapon->perks as $perk)
                        <li>{{ $perk->name }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="w-1/2">
                <h2 class="w-full">Attributes</h2>
                <ul>
                    @foreach($weapon->attributes as $attribute)
                        <li>{{ $attribute->pivot->amount }} {{ $attribute->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

</x-app-layout>
