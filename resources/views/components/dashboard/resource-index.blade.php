@props(['title', 'class', 'entityName', 'pluralEntityName', 'instance'=>null])

@can('viewAny', $class)
    <x-dashboard.section
        :title="$title"
        class=""
    >
        @if(Route::has($pluralEntityName.'.index'))
            <x-dashboard.gated-button 
                :phpClass="$class"
                :can="'viewAll'" 
                :route="route($pluralEntityName.'.index')"
            >
                View All
            </x-dashboard.gated-button>
        @endif

        @if(Route::has($pluralEntityName.'.show'))
            <x-dashboard.gated-button 
                :phpClass="$class" 
                :can="'view'"
                :route="isset($instance) 
                    ? route($pluralEntityName.'.show', [$entityName=>$instance]) 
                    : route($pluralEntityName.'.choose')"
                :instance="$instance"
            >
                View
            </x-dashboard.gated-button>
        @endif
        
        @if(Route::has($pluralEntityName.'.create'))
            <x-dashboard.gated-button 
                :phpClass="$class" 
                :can="'create'"
                :route="route($pluralEntityName.'.create')"
            >
                Create
            </x-dashboard.gated-button>
        @endif
        
        @if(Route::has($pluralEntityName.'.edit'))
            <x-dashboard.gated-button 
                :phpClass="$class" 
                :can="'update'"
                :route="isset($instance) 
                    ? route($pluralEntityName.'.edit', [$entityName=>$instance]) 
                    : route($pluralEntityName.'.choose')"
                :instance="$instance"
            >
                Edit
            </x-dashboard.gated-button>
        @endif
        
        @if(Route::has($pluralEntityName.'.destroy'))
            <x-dashboard.gated-button 
                :phpClass="$class" 
                :can="'delete'"
                :route="isset($instance) 
                    ? route($pluralEntityName.'.destroy', [$entityName=>$instance]) 
                    : route($pluralEntityName.'.choose')"
                :instance="$instance"
            >
                Delete
            </x-dashboard.gated-button>
        @endif
        
        {!! $slot !!}
        
    </x-dashboard.section>
@endcan
