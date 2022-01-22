
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

    <x-dashboard.edit-delete-bank-item-buttons
        :item="$instance"
        :itemType="$row->type"            
        :guildBank="$guildBank"
        {{--            :guildBankClass="$guildBankClass"--}}
        class="mt-4"
    />
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