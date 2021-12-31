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
        
            <x-dashboard.section 
                :title="'Import'"
                class="min-w-1/3 mb-6 lg:mr-6"
            >
                <x-button-link href="{{ route('import.create') }}">
                    Import Roster
                </x-button-link>
            </x-dashboard.section>
            
            <x-dashboard.section 
                :title="'Rosters'"
                class="min-w-1/3 mb-6"
            >
                <x-button-link href="{{-- route('rosters.index') --}}">
                    View All
                </x-button-link>
            </x-dashboard.section>
        
            <x-dashboard.section 
                :title="'Characters'"
                class="min-w-1/3 mb-6 lg:mr-6"
            >
                <x-button-link href="{{ route('characters.index') }}">
                    View All
                </x-button-link>
                
                <x-button-link href="{{ route('characters.create') }}">
                    Create
                </x-button-link>

                <x-button-link href="{{ route('characters.choose') }}">
                    Edit / Delete
                </x-button-link>
            </x-dashboard.section>

            <x-dashboard.section
                :title="'Loadouts'"
                class="min-w-1/3 mb-6"
            >
                <x-button-link href="{{ route('loadouts.index') }}">
                    View All
                </x-button-link>
                
                <x-button-link href="{{ route('loadouts.create') }}">
                    Create
                </x-button-link>

                <x-button-link href="{{ route('loadouts.choose') }}">
                    Edit / Delete
                </x-button-link>
            </x-dashboard.section>

            <x-dashboard.section
                :title="'Companies'"
                class="min-w-1/3 mb-6 lg:mr-6"
            >
                <x-button-link href="{{ route('companies.index') }}">
                    View All
                </x-button-link>
            
                <x-button-link href="{{ route('companies.create') }}">
                    Create
                </x-button-link>

                <x-button-link href="{{ route('companies.choose') }}">
                    Edit / Delete
                </x-button-link>
                
                <x-forms.form
                    {{-- send as plain html attribute --}}
                    action="{{ route('companies.find') }}"
                    {{-- set the custom $method variable --}}
                    {{-- (not the form method attribute) --}}
                    :method="$method ?? null"
                    class="w-full mx-0 mt-8"
                >
                    <x-forms.field :name="'company'" class="w-full">
                        <x-forms.label for="company" :required="true" class="inline-block text-lg mr-2">
                            View all members for:
                        </x-forms.label>
                        <x-forms.select id="company" type="text" name="company" class="inline-block" 
                            :required="true" 
                            :values="
                                \App\Models\Company::with('faction')
                                    ->orderBy('name')->get()
                                    ->mapWithKeys(function($company){
                                        return [$company->name.' ('.$company->faction->name.')' => $company->slug];
                                    })
                                    ->all()
                            "
                        />
                    </x-forms.field>
                    
                    <x-slot name="button">
                        <div class="flex flex-wrap">
                            <x-button name="action" value="show">View All Members</x-button>
                        </div>
                    </x-slot>
                    
                </x-forms.form>
                
            </x-dashboard.section>

            <x-dashboard.section
                :title="'Factions'"
                class="min-w-1/3  mb-6"
            >
                <x-button-link href="{{ route('factions.index') }}">
                    View All
                </x-button-link>
                
                <x-button-link href="{{ route('factions.create') }}">
                    Create
                </x-button-link>

                <x-button-link href="{{ route('factions.choose') }}">
                    Edit / Delete
                </x-button-link>
            </x-dashboard.section>
            
            <x-dashboard.section
                :title="'Weapons'"
                class="min-w-1/3  mb-6"
            >
                <x-button-link href="{{ route('weapons.index') }}">
                    View All
                </x-button-link>
                
                <x-button-link href="{{ route('weapons.create') }}">
                    Create
                </x-button-link>

                <x-button-link href="{{ route('weapons.choose') }}">
                    Edit / Delete
                </x-button-link>
            </x-dashboard.section>
        </div>
    </div>

    {{--<ul>
    @foreach($characters as $character)
        <li><h2 class="text-lg font-bold">Character</h2> {{ $character->name }} ({{ $character->user->name }})</li>
        <li><h3 class="text-lg font-bold">Class</h3> {{ $character->class->name }}, {{ $character->class->type->name }}</li>
        <li>
            <h3 class="text-lg font-bold">Skills</h3>
            <ul class="ml-4">
                @foreach($character->skills as $skill)
                    <li>{{ $skill->name }} <em>({{ $skill->type->name }})</em></li>
                @endforeach
            </ul>
        </li>
        <li class="border-b pb-4 mb-4">
            <h3 class="text-lg font-bold">Loadout</h3>
            <ul>
                @foreach($character->loadouts as $loadout)
                    <li>
                        <ul class="ml-4">
                            --}}{{--<li>Name: {{ $loadout->name }}</li>--}}{{--
                            <li><strong>Weight:</strong> {{ $loadout->weight }}</li>
                            <li><strong>Main Hand:</strong> {{ $loadout->main->name }} <em>({{ $loadout->main->type->name }})</em></li>
                            <li><strong>Off Hand:</strong> {{ $loadout->offhand->name }} <em>({{ $loadout->offhand->type->name }})</em></li>
                        </ul>
                    </li>
                @endforeach
            </ul> 
        </li>
    @endforeach
    </ul>--}}
</x-app-layout>
