@props(['title'])

<h2 class="font-semibold text-xl text-gray-800 leading-tight flex justify-between">
    <div class="flex-grow flex flex-wrap">{{ $title ?? '' }}</div>
    @if( session('character') !== null )
        <span id="character-heading" class="text-gray-600">
            @if(session('character')->rank !== null)
                {{ session('character')->rank->name }} 
                <span class="text-gray-400">/</span>
            @endif 
            {{ session('character')->company?->name ?? '' }} 
            <span class="text-gray-400">/</span> 
            {{ session('character')->name ?? '' }}
        </span>
    @endif
</h2>