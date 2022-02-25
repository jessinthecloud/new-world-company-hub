<x-layouts.dashboard>
    <x-dashboard.section
        :title="'War Board'"
    >    
        <div class="board-wrapper flex flex-wrap w-full" x-data="{
            // when an element is being added
            adding: false, 
            // when an element is being removed
            removing: false
        }">
            <div class="war-board w-3/4 grid grid-cols-5 grid-rows-3 gap-2 p-2">
                @for($i=0;$i<10;$i++)
                    <!-- drop target -->
                    <x-events.war-group :title="'Group '.($i+1)" />
                @endfor
                @for($i=0;$i<5;$i++)
                    <!-- drop target -->
                    <x-events.war-group :title="'Alt Group '.($i+1)" />
                @endfor
            </div>
            
            <ul class="character-list w-1/4 max-h-screen overflow-auto" 
                x-on:drop="removing = false"
                x-on:drop.prevent="const id = event.dataTransfer.getData('text/plain');
                    const target = event.target.closest('ul');
                    const element = document.getElementById(id);
                    target.appendChild(element);
                    element.classList.remove('bg-gray-300');
                    element.classList.add('flex');
                    element.classList.remove('flex-col');
                    let spacer = document.createElement('div');
                    element.appendChild(spacer);
                "
                x-on:dragover.prevent="removing = true"
                x-on:dragleave.prevent="removing = false"
            >
                @foreach($chars as $char)
                    <li id="{{$char->name}}-list-item" 
                        class="flex justify-between items-center p-1 mt-1 hover:bg-gray-100"
                        style="cursor:grab; /* tailwind not working */"
                        :class="{ 'cursor-grabbing': dragging }"
                        draggable="true"
                        x-data="{ dragging: false }"
                        x-on:dragend="dragging = false"
                         {{--*.self listener modifier only triggers if 
                        the event target is this element--}}
                        x-on:dragstart.self="
                            dragging = true
                            event.dataTransfer.effectAllowed = 'move';
                            // set the data to bring to the droppable target
                            event.dataTransfer.setData('text/plain', event.target.id);
                        "
                    >
                        <div class="w-3/6">{{ $char->name }}</div>
                        <div class="w-2/6">{{ $char->class->name }}</div> 
                        @if($char->loadout?->approved())
                            <x-utils.icons.checkmark class="w-1/6 text-green-500"/>
                        @else
                            <div class="w-1/6"></div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </x-dashboard.section>
</x-layouts.dashboard>