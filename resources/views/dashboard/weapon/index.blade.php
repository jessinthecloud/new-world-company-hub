@can('viewAny', \App\Models\BaseWeapon::class)
    <x-dashboard.section
        :title="'Weapon'"
        class=""
    >
        <x-dashboard.view-all-button 
            :class="\App\Models\BaseWeapon::class" 
            :route="route('weapons.index')"
        />
        @isset($weapon)
        <x-dashboard.view-own-button 
            :class="\App\Models\BaseWeapon::class" 
            :route="route('weapons.show', ['weapon'=>$weapon])"
            :instance="$weapon"
        />
        @endisset
        <x-dashboard.create-button 
            :class="\App\Models\BaseWeapon::class" 
            :route="route('weapons.create')"
            :instance="$weapon ?? null"
        />
        <x-dashboard.edit-delete-button 
            :class="\App\Models\BaseWeapon::class" 
            :route="route('weapons.choose')"
            :instance="$weapon ?? null"
        />
    </x-dashboard.section>
@endcan
