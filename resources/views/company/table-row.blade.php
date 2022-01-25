<x-livewire-tables::table.cell
    class="max-w-sm"
    {{-- tailwind not doing these:--}} 
    style="white-space:normal; min-width:225px; max-width:250px; "
>
    {{ ucfirst($row->name) }}

    @if(Route::has('guild-banks.destroy'))
        @can("delete", $row)
            <x-forms.form
                {{-- send as plain html attribute --}}
                action="{{  route('characters.destroy', [
                    'character' => $row->slug
                ]) }}"
                {{-- set the custom $method variable --}}
                {{-- (not the form method attribute) --}}
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

<x-livewire-tables::table.cell>
    {{ $row->discord_name }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ $row->name }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at, new \DateTimeZone('America/New_York'))->format("g:i A M j Y") }}
</x-livewire-tables::table.cell>