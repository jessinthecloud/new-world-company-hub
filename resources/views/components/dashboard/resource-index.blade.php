@props(['title', 'class', 'entity_name', 'pluralEntityName', 'instance'=>null])

@can('viewAny', $class)
    <x-dashboard.section
        :title="$title"
        class=""
    >
        <x-dashboard.gated-button 
            :phpClass="$class"
            :can="'viewAll'" 
            :route="route($pluralEntityName.'.index')"
        >
            View All
        </x-dashboard.gated-button>

        <x-dashboard.gated-button 
            :phpClass="$class" 
            :can="'view'"
            :route="isset($guildBank) 
                ? route($pluralEntityName.'.edit', [$entity_name=>$instance]) 
                : route($pluralEntityName.'.choose')"
            :instance="$instance"
        >
            View
        </x-dashboard.gated-button>
        
        <x-dashboard.gated-button 
            :phpClass="$class" 
            :can="'create'"
            :route="route($pluralEntityName.'.create')"
        >
            Create
        </x-dashboard.gated-button>
        
        <x-dashboard.gated-button 
            :phpClass="$class" 
            :can="'update'"
            :route="isset($guildBank) 
                ? route($pluralEntityName.'.edit', [$entity_name=>$instance]) 
                : route($pluralEntityName.'.choose')"
            :instance="$instance"
        >
            Edit
        </x-dashboard.gated-button>
        
        <x-dashboard.gated-button 
            :phpClass="$class" 
            :can="'delete'"
            :route="isset($guildBank) 
                ? route($pluralEntityName.'.edit', [$entity_name=>$instance]) 
                : route($pluralEntityName.'.choose')"
            :instance="$instance"
        >
            Delete
        </x-dashboard.gated-button>
        
        {!! $slot !!}
        
    </x-dashboard.section>
@endcan
