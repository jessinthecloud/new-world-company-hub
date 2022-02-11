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
    @if(Route::has('company.members.destroy'))
        @can("removeMembers", $row->company)
            <x-forms.form
                action="{{  route('company.members.destroy', [
                    'company' => $row->company->slug,
                    'character' => $row->slug,
                ]) }}"
                :method="'DELETE'"
                class="mt-2"
            >
                <x-slot name="button">
                    <x-button 
                        name="action" 
                        value="delete" 
                        class="bg-red-800"
                    >
                        Remove
                    </x-button>
                </x-slot>
            </x-forms.form>
        @endcan
    @endif
</x-livewire-tables::table.cell>