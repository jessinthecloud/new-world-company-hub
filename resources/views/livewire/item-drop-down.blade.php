<div class="relative w-11/12 md:w-auto" x-data="{ isVisible: true}" @click.away="isVisible=false">
    {{-- wire model will update the value of the property on the class
    search is public property on the class
    debounce - prevent requests within certain time 
        (to prevent too many as you type) --}}
    <input 
        wire:model.debounce.300ms="search" 
        type="text" 
        class="
            w-full rounded-md shadow-sm border-gray-300 
            focus:border-indigo-300 
            focus:ring 
            focus:ring-indigo-200 
            focus:ring-opacity-50
        " 
        placeholder="Search Item"
        {{-- 
        below are event listeners that set the var from x-data when fired
        
        @focus - bring the dropdown back (x-show on the list below) 
        @keydown.escape.window - if escape is pressed anywhere, bring dd back
        @keydown - if any key is pressed inside the input, bring dd back
        @keydown.shift.tab - if shift and tab are pressed (move focus backwards) then hide the dd
        --}}
        @focus="isVisible=true" 
        @keydown.escape.window="isVisible=false"
        @keydown="isVisible=true"
        @keydown.shift.tab="isVisible=false"
    > <!-- end search input tag -->

    <!-- magnifying glass icon -->
    {{--<div class="absolute top-0 flex items-center h-full ml-2">
        <svg class="fill-current text-gray-400 w-4" viewBox="0 0 24 24"><path class="heroicon-ui" d="M16.32 14.9l5.39 5.4a1 1 0 01-1.42 1.4l-5.38-5.38a8 8 0 111.41-1.41zM10 16a6 6 0 100-12 6 6 0 000 12z"/></svg>
    </div>--}}
 
    <!-- dynamic drop down -->
    @if(strlen($search) >= 3)
        {{-- don't show until we've typed a search --}}
        <div class="absolute z-50 text-sm w-64 mt-2" 
            x-show.transition.opacity.duration.250="isVisible"
        >
            @if(count($search_results) > 0)
                <ul>
                    @foreach($search_results as $result)
                        <li wire:key="{{ $loop->index }}" 
                            class="border-b border-gray-400 block px-3 py-3 flex items-center transition ease-in-out duration-150 cursor-pointer"
                            @click=""
                        
                        {{-- if we are on last item,
                        if press tab (focus off), hide dropdown --}}
                        @if($loop->last)
                            @keydown.tab="isVisible=false"
                        @endif
                        >
                             @if(!empty($result['image_url']))
                                <img src="{{ $result['image_url'] }}" alt="{{ $result['name'] }}" class="w-10 cursor-pointer">
                            @endif 
                            <span class="ml-4 cursor-pointer">{{ $result['name'] }} - <strong>{{ $result['type'] }}</strong></span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="px-3 py-3">No Results for <em>{{ $search }}</em></div>
            @endif
        </div>
    @endif
</div>
