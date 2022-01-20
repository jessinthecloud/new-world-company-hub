<x-livewire-tables::table.cell>
    {{ ucfirst($row->name) }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ $row->gear_score }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell class="w-md max-w-md">
    <?php
    $itemtable = Str::plural(strtolower($row->type));
    $perk_names = App\Models\Items\Perk::whereRelation($itemtable, $itemtable.'.id', '=', $row->id)->orderBy('name')->get();
    ?>
    {{  $perk_names->pluck('name')->implode(', ') }}
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
    <div class="flex flex-wrap">
        @php $instance = "App\\Models\\Items\\{$row->type}"::find($row->id) @endphp
        <x-dashboard.gated-button
            :can='["edit", $instance]'
            :phpClass='"App\\Models\\Items\\{$row->type}"'
            :route="route('guild-banks.edit', [
                'guildBank' => $instance->company->slug,
                'itemType' => $row->type,
                'item' => $instance->slug
            ])"
            :instance="$instance"
        >
            Edit
        </x-dashboard.gated-button>
        
        @can("delete", $instance)
            <x-forms.form
                {{-- send as plain html attribute --}}
                action="{{  route('guild-banks.destroy', [
                    'guildBank' => $instance->company->slug,
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
