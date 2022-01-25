@props(['title', 'phpClass', 'entityName', 'pluralEntityName', 'instance'=>null, 'buttonTexts'=>[], 'inventoryItem'])

@can('viewAny', $phpClass)
    <x-dashboard.section
        :title="$title"
        class=""
    >
        @if(Route::has($pluralEntityName.'.inventory.index') && isset($instance))
            <x-dashboard.gated-button
                :can="['viewAll', $phpClass]"
                :phpClass="$phpClass"
                :route="route(
                    $pluralEntityName.'.inventory.index', 
                    [
                        $entityName=>$instance->slug,
                    ]
                )"
            >
                {{ $buttonTexts['viewAll'] ?? 'View All' }}
            </x-dashboard.gated-button>
        @endif

        {{--@if(Route::has($pluralEntityName.'.inventory.show'))
            <x-dashboard.gated-button
                :can="['view', $instance]"
                :phpClass="$phpClass" 
                :route="route(
                    $pluralEntityName.'.inventory.show', 
                    [
                        $entityName=>$instance->slug,
                        'inventoryItem'=>$inventoryItem->slug
                    ]
                )"
                :instance="$instance"
            >
                {{ $buttonTexts['view'] ?? 'View' }}
            </x-dashboard.gated-button>
        @endif--}}
        
        @if(Route::has($pluralEntityName.'.create') && isset($instance))
            <x-dashboard.gated-button 
                :can="['create', $phpClass]"
                :phpClass="$phpClass"
                {{--:route="route($pluralEntityName.'.create')"--}}
                :route="route(
                    $pluralEntityName.'.inventory.create', 
                    [
                        $entityName=>$instance->slug,
                    ]
                )"
            >
                {{ $buttonTexts['create'] ?? 'Create' }}
            </x-dashboard.gated-button>
        @endif
        
        @if(Route::has($pluralEntityName.'.edit') && isset($instance))
            <x-dashboard.gated-button
                :can="['update', $instance]"
                :phpClass="$phpClass" 
                :route="route(
                    $pluralEntityName.'.inventory.edit', 
                    [
                        $entityName=>$instance->slug,
                        'inventoryItem'=>$inventoryItem->slug
                    ]
                )"
                :instance="$instance"
            >
                {{ $buttonTexts['edit'] ?? 'Edit' }}
            </x-dashboard.gated-button>
        @endif
        
        @if(Route::has($pluralEntityName.'.destroy'))
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
            
            {{--<x-dashboard.gated-button 
                :can="['delete', $instance]"
                :phpClass="$phpClass"
                :route="isset($instance) 
                    ? route($pluralEntityName.'.choose', ['action'=>'destroy', $entityName=>$instance->slug]) 
                    : route($pluralEntityName.'.choose', ['action'=>'destroy'])"
                :instance="$instance"
                class="bg-red-800"
            >
                {{ $buttonTexts['delete'] ?? 'Delete' }}
            </x-dashboard.gated-button>--}}
        @endif
        
        {!! $slot !!}
        
    </x-dashboard.section>
@endcan
