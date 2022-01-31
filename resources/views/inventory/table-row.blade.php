<x-livewire-tables::table.cell
    class="max-w-sm border-l-4 border-{{ strtolower($row->item->itemable->rarity) }}-500"
    {{-- tailwind not doing these:--}} 
    style="white-space:normal; min-width:225px; max-width:250px; "
>
    {{ ucfirst($row->item->itemable->name) }}

    <x-dashboard.edit-delete-inventory-item-buttons
        :item="$row"
        :owner="$row->ownerable"
        :ownerType="Str::afterLast(strtolower($row->ownerable_type), '\\')"
        class="mt-4"
    />
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ $row->item->itemable->gear_score }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell 
    class="!whitespace-normal"
    {{-- tailwind not doing these:--}} 
    style="white-space:normal; min-width:200px; ">

    @php 
        $itemtable = Str::plural(strtolower(Str::afterLast($row->item->itemable_type,'\\')));
        $perk_names = App\Models\Items\Perk::whereRelation(
            $itemtable, $itemtable.'.id', '=', $row->item->itemable->id
        )->orderBy('name')->get();
    @endphp

    {!! $perk_names->pluck('name')->implode(', <BR>') !!}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ Str::afterLast($row->item->itemable_type, '\\') }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ $row->item->itemable->type }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ $row->item->itemable->rarity }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ $row->item->itemable->weight_class }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $row->item->itemable->created_at, new \DateTimeZone('America/New_York'))->format("g:i A M j Y") }}
</x-livewire-tables::table.cell>