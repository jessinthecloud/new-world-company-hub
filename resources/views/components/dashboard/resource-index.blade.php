@props(['title', 'phpClass', 'entityName', 'pluralEntityName', 'instance'=>null, 'buttonTexts'=>[]])

@can('viewAny', $phpClass)
    <x-dashboard.section
        :title="$title"
        class=""
    >
        @if(Route::has($pluralEntityName.'.index'))
            <x-dashboard.gated-button
                :can="['viewAll', $phpClass]"
                :phpClass="$phpClass"
                :route="route($pluralEntityName.'.index')"
            >
                {{ $buttonTexts['viewAll'] ?? 'View All' }}
            </x-dashboard.gated-button>
        @endif

        @if(Route::has($pluralEntityName.'.show') && Route::has($pluralEntityName.'.choose'))
            <x-dashboard.gated-button
                :can="['view', $instance]"
                :phpClass="$phpClass" 
                :route="isset($instance) 
                    ? route($pluralEntityName.'.show', [$entityName=>$instance->slug]) 
                    : route($pluralEntityName.'.choose', ['action'=>'show'])"
                :instance="$instance"
            >
                {{ $buttonTexts['view'] ?? 'View' }}
            </x-dashboard.gated-button>
        @endif
        
        @if(Route::has($pluralEntityName.'.create'))
            <x-dashboard.gated-button 
                :can="['create', $phpClass]"
                :phpClass="$phpClass"
                {{--:route="route($pluralEntityName.'.create')"--}}
                :route="isset($instance) 
                    ? route($pluralEntityName.'.create', [$entityName=>$instance->slug]) 
                    : route($pluralEntityName.'.choose', ['action'=>'create'])"
            >
                {{ $buttonTexts['create'] ?? 'Create' }}
            </x-dashboard.gated-button>
        @endif
        
        @if(Route::has($pluralEntityName.'.edit') && Route::has($pluralEntityName.'.choose'))
            <x-dashboard.gated-button
                :can="['update', $instance]"
                :phpClass="$phpClass" 
                :route="isset($instance) 
                    ? route($pluralEntityName.'.choose', ['action'=>'edit-item-type', $entityName=>$instance->slug]) 
                    : route($pluralEntityName.'.choose', ['action'=>'edit'])"
                :instance="$instance"
            >
                {{ $buttonTexts['edit'] ?? 'Edit' }}
            </x-dashboard.gated-button>
        @endif
        @if(Route::has($pluralEntityName.'.destroy') && Route::has($pluralEntityName.'.choose'))
<!--                --><?php //dump(Route::has($pluralEntityName.'.destroy'),Route::has($pluralEntityName.'.choose'),$instance);?>
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
                :phpClass="$phpClass"
                :route="isset($instance) 
                    ? route($pluralEntityName.'.choose', ['action'=>'destroy', $entityName=>$instance->slug]) 
                    : route($pluralEntityName.'.choose', ['action'=>'destroy'])"
                :instance="$instance"
                class="bg-red-800"
            >
                {{ $buttonTexts['delete'] ?? 'Delete' }}
            </x-dashboard.gated-button>
        @endif
        
        {!! $slot !!}
        
    </x-dashboard.section>
@endcan
