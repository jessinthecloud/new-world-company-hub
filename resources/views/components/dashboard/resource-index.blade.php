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

        @if(isset($instance) && Route::has($pluralEntityName.'.show')  
            && $phpClass != \App\Models\Characters\Character::class)
            <x-dashboard.gated-button
                :can="['view', $instance]"
                :phpClass="$phpClass" 
                :route="route($pluralEntityName.'.show', [$entityName=>$instance->slug])"
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
                :route="route($pluralEntityName.'.create', [$entityName=>$instance?->slug])"
            >
                {{ $buttonTexts['create'] ?? 'Create' }}
            </x-dashboard.gated-button>
        @endif
        
        @if(isset($instance) && Route::has($pluralEntityName.'.edit'))
            <x-dashboard.gated-button
                :can="['update', $instance]"
                :phpClass="$phpClass" 
                :route="route($pluralEntityName.'.edit', [$entityName=>$instance->slug])"
                :instance="$instance"
            >
                {{ $buttonTexts['edit'] ?? 'Edit' }}
            </x-dashboard.gated-button>
        @endif
        
        {!! $slot !!}
        
    </x-dashboard.section>
@endcan
