@props(['title', 'phpClass', 'entityName', 'pluralEntityName', 'instance'=>null, 'buttonTexts'=>[]])

@can('viewAny', App\Models\Characters\Character::class)
    <x-dashboard.section
        :title="$title"
        class=""
    >
        @if(Route::has('characters.index'))
            <x-dashboard.gated-button
                :can="['viewAll', App\Models\Characters\Character::class]"
                :phpClass="App\Models\Characters\Character::class"
                :route="route('characters.index')"
            >
                {{ $buttonTexts['viewAll'] ?? 'View All' }}
            </x-dashboard.gated-button>
        @endif

        @if(Route::has('characters.show') && Route::has('characters.choose'))
            <x-dashboard.gated-button
                :can="['view', $instance]"
                :phpClass="App\Models\Characters\Character::class" 
                :route="isset($instance) 
                    ? route('characters.show', ['character'=>$instance->slug]) 
                    : route('characters.choose', ['action'=>'show'])"
                :instance="$instance"
            >
                {{ $buttonTexts['view'] ?? 'View' }}
            </x-dashboard.gated-button>
        @endif
        
        @if(Route::has('characters.create'))
            <x-dashboard.gated-button 
                :can="['create', App\Models\Characters\Character::class]"
                :phpClass="App\Models\Characters\Character::class"
                :route="route('characters.create')"
            >
                {{ $buttonTexts['create'] ?? 'Create' }}
            </x-dashboard.gated-button>
        @endif
        
        @if(Route::has('characters.edit') && Route::has('characters.choose'))
            <x-dashboard.gated-button
                :can="['update', $instance]"
                :phpClass="App\Models\Characters\Character::class" 
                :route="isset($instance) 
                    ? route('characters.choose', ['action'=>'edit-item-type', 'character'=>$instance->slug]) 
                    : route('characters.choose', ['action'=>'edit'])"
                :instance="$instance"
            >
                {{ $buttonTexts['edit'] ?? 'Edit' }}
            </x-dashboard.gated-button>
        @endif
        @if(Route::has('characters.destroy') && Route::has('characters.choose'))
<!--                --><?php //dump(Route::has('characters.destroy'),Route::has('characters.choose'),$instance);?>
            {{--@can('delete', $instance)
                <x-forms.form
                    --}}{{-- send as plain html attribute --}}{{--
                    action="{{ $form_action ?? '' }}"
                    --}}{{-- set the custom $method variable --}}{{--
                    --}}{{-- (not the form method attribute) --}}{{--
                    :method="$method ?? null"
                    :button-text="$button_text"
                    class="flex flex-wrap justify-start"
                    
                     x-data="{weapons: {}, armors: {}, isWeapon:{{ $isWeapon ?? 0 }}, isArmor:{{ $isArmor ?? 0 }}, newEntry:{{ $newEntry ?? 0 }}, fetch:false}"
                >
                </x-forms.form>
            @endcan--}}
            
            <x-dashboard.gated-button 
                :can="['delete', $instance]"
                :phpClass="App\Models\Characters\Character::class"
                :route="isset($instance) 
                    ? route('characters.choose', ['action'=>'destroy', 'character'=>$instance->slug]) 
                    : route('characters.choose', ['action'=>'destroy'])"
                :instance="$instance"
                class="bg-red-800"
            >
                {{ $buttonTexts['delete'] ?? 'Delete' }}
            </x-dashboard.gated-button>
        @endif
        
        {!! $slot !!}
        
    </x-dashboard.section>
@endcan
