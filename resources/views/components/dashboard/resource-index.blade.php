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

        @if(Route::has($pluralEntityName.'.show') && Route::has($pluralEntityName.'.choose')  
            && $phpClass != \App\Models\Characters\Character::class)
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
        
        @if(Route::has($pluralEntityName.'.create') 
            && $phpClass != \App\Models\Characters\Character::class)
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
        
        @if(Route::has($pluralEntityName.'.edit') /*&& Route::has($pluralEntityName.'.choose')*/)
            <x-dashboard.gated-button
                :can="['update', $instance]"
                :phpClass="$phpClass" 
                :route="isset($instance) 
                    ? route($pluralEntityName.'.edit', [$entityName=>$instance->slug]) 
                    : route($pluralEntityName.'.choose', ['action'=>'edit'])"
                :instance="$instance"
            >
                {{ $buttonTexts['edit'] ?? 'Edit' }}
            </x-dashboard.gated-button>
        @endif
        
        @if(Route::has($pluralEntityName.'.destroy') 
            && $phpClass != \App\Models\Characters\Character::class)
       
            @can('delete', $instance)
                <x-forms.form
                    action="{{ $form_action ?? '' }}"
                    :method="$method ?? null"
                    class="flex flex-wrap justify-start"
                >
                    <x-slot name="button">
                        <x-button class="bg-red-800">
                            Delete
                        </x-button>
                    </x-slot>
                </x-forms.form>
            @endcan
            
            {{--<x-dashboard.gated-button 
                :can="['delete', $instance]"
                :phpClass="$phpClass"
                :route="route($pluralEntityName.'.destroy', [$entityName=>$instance->slug])"
                :instance="$instance"
                class="bg-red-800"
            >
                {{ $buttonTexts['delete'] ?? 'Delete' }}
            </x-dashboard.gated-button>--}}
            
        @endif
        
        {!! $slot !!}
        
    </x-dashboard.section>
@endcan
