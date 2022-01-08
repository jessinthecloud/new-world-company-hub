@can('viewAny', \App\Models\BaseWeapon::class)
    <x-dashboard.section
        :title="'Weapon'"
        class=""
    >
        <x-dashboard.view-all-button 
            :class="\App\Models\BaseWeapon::class" 
            :route="route('weapons.index')"
        />
        <x-dashboard.view-own-button 
            :class="\App\Models\BaseWeapon::class" 
            :route="route('weapons.show', ['weapon'=>$weapon])"
            :instance="$weapon"
        />
        <x-dashboard.create-button 
            :class="\App\Models\BaseWeapon::class" 
            :route="route('weapons.create')"
            :instance="$weapon"
        />
        <x-dashboard.edit-delete-button 
            :class="\App\Models\BaseWeapon::class" 
            :route="route('weapons.choose')"
            :instance="$weapon"
        />
    </x-dashboard.section>
@endcan
