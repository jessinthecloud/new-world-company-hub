
@php 
$itemtable = Str::plural(strtolower($row->type));
$perk_names = App\Models\Items\Perk::whereRelation($itemtable, $itemtable.'.id', '=', $row->id)->orderBy('name')->get();
$instance = "App\\Models\\Items\\{$row->type}"::find($row->id);
$guildBank = new \App\GuildBank($instance->company);
@endphp

<x-livewire-tables::table.cell
    class="max-w-sm"
    {{-- tailwind not doing these:--}} 
    style="white-space:normal; min-width:225px; max-width:250px; "
>
    {{ ucfirst($row->name) }}
    
    <div class="flex flex-wrap mt-4">
        
        <x-dashboard.gated-button
            :can='["update", $guildBank]'
            :phpClass='"App\\Models\\Items\\GuildBank"'
            :route="route('guild-banks.edit', [
                'guildBank' => $guildBank->slug,
                'itemType' => $row->type,
                'item' => $instance->slug
            ])"
            class="px-2"
        >
            Edit
        </x-dashboard.gated-button>
        
        @can("delete", $guildBank)
            <x-forms.form
                {{-- send as plain html attribute --}}
                action="{{  route('guild-banks.destroy', [
                    'guildBank' => $guildBank->slug,
                    'itemType' => $row->type,
                    'item' => $instance->id,
                    'action'=>'destroy',
                ]) }}"
                {{-- set the custom $method variable --}}
                {{-- (not the form method attribute) --}}
                :method="'DELETE'"
            >
                <x-slot name="button">
                    <x-button 
                        name="action" 
                        value="delete" 
                        class="bg-red-800"
                    >
                        Delete
                    </x-button>
                </x-slot>
            </x-forms.form>
        @endcan
    </div>
    
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ $row->gear_score }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell 
    class="!whitespace-normal"
    {{-- tailwind not doing these:--}} 
    style="white-space:normal; min-width:200px; ">
    {!! $perk_names->pluck('name')->implode(', <BR>') !!}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ $row->type }}
    {{--@if ($row->isAdmin())
        @lang('All')
    @elseif (! $row->permissions->count())
        @lang('None')
    @else
        {!! collect($row->permissions->pluck('description'))->implode('<br/>') !!}
    @endif--}}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ $row->subtype }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ $row->rarity }}
    {{--@if(! $row->isAdmin())
        <a href="{{ route('admin.auth.role.edit', $row) }}" class="text-primary-600 font-medium hover:text-primary-900">Manage</a>
    @else
        <span>-</span>
    @endif--}}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ $row->weight_class }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at, new \DateTimeZone('America/New_York'))->format("g:i A M j Y") }}
</x-livewire-tables::table.cell>