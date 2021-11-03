<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <ul>
                    @foreach($characters as $character)
                        <li>User: {{ $character->user->name }}</li>
                        <li>Character: {{ $character->name }}</li>
                        <li>Class: {{ $character->class->name }}, {{ $character->class->type->name }}</li>
                        <li>Skills: {{ $character->skills->toString() }}</li>
                        <li>Loadout: {{ $character->loadout->toString() }}</li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
