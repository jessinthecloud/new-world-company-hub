<x-livewire-tables::table.cell
    class="center"
>
    <x-utils.icons.war-ready :loadout="$row->loadout"/>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell
    class="max-w-sm"
    {{-- tailwind not doing these:--}} 
    style="white-space:normal; min-width:225px; max-width:250px; "
>
    {{ $row->name }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ $row->user->discord_name }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ $row->class->name }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at, new \DateTimeZone('America/New_York'))->format("g:i A M j Y") }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    @if(Route::has('loadouts.show') && isset($row->loadout))
        <x-dashboard.gated-button
            :can="['view', $row->loadout]"
            :route-name="'loadouts.show'"
            :route="route('loadouts.show', [
                'loadout'=>$row->loadout?->id,
            ])"
        ></x-dashboard.gated-button>
    @endif
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    <x-utils.gated-button-form
        :can="['removeMembers', $row->company]"
        :method="'DELETE'"
        :route-name="'company.members.destroy'"
        :route=" route('company.members.destroy', [
            'company' => $row->company->slug,
            'character' => $row->slug,
        ])"
    >
        Kick
    </x-utils.gated-button-form>
</x-livewire-tables::table.cell>