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
            <div class="war-board flex-grow flex flex-wrap mr-4 border border-black">
    
                <!-- drop target -->
                <ul class="war-group drop-target w-1/5 bg-gray-300 mx-1 border border-black"
                    {{--:class="{ 'bg-green-300': adding }"--}}
                    x-on:drop="adding = false"
                    x-on:drop.prevent="const id = event.dataTransfer.getData('text/plain');
                        const target = event.target.closest('ul');
                        const element = document.getElementById(id);
                        target.appendChild(element);
                        element.classList.add('border border-black p-1 rounded');
                    "
                    x-on:dragover.prevent="adding = true"
                    x-on:dragleave.prevent="adding = false"
                >
                    <h3>Group 1</h3>
                </ul>
                
                <!-- drop target -->
                <ul class="war-group drop-target w-1/5 bg-gray-300 mx-1 border border-black" 
                    x-on:drop="adding = false"
                    x-on:drop.prevent="const id = event.dataTransfer.getData('text/plain');
                        const target = event.target.closest('ul');
                        const element = document.getElementById(id);
                        target.appendChild(element);
                    "
                    x-on:dragover.prevent="adding = true"
                    x-on:dragleave.prevent="adding = false"
                >
                    <h3>Group 2</h3>
                </ul>
                
                <!-- drop target -->
                <ul class="war-group drop-target w-1/5 bg-gray-300 mx-1 border border-black" 
                    x-on:drop="adding = false"
                    x-on:drop.prevent="const id = event.dataTransfer.getData('text/plain');
                        const target = event.target.closest('ul');
                        const element = document.getElementById(id);
                        target.appendChild(element);
                    "
                    x-on:dragover.prevent="adding = true"
                    x-on:dragleave.prevent="adding = false"
                >
                    <h3>Group 3</h3>
                </ul>
                
                <!-- drop target -->
                <ul class="war-group drop-target w-1/5 bg-gray-300 mx-1 border border-black" 
                    x-on:drop="adding = false"
                    x-on:drop.prevent="const id = event.dataTransfer.getData('text/plain');
                        const target = event.target.closest('ul');
                        const element = document.getElementById(id);
                        target.appendChild(element);
                    "
                    x-on:dragover.prevent="adding = true"
                    x-on:dragleave.prevent="adding = false"
                >
                    <h3>Group 4</h3>
                </ul>
                
                <!-- drop target -->
                <ul class="war-group drop-target w-1/5 bg-gray-300 mx-1 border border-black" 
                    x-on:drop="adding = false"
                    x-on:drop.prevent="const id = event.dataTransfer.getData('text/plain');
                        const target = event.target.closest('ul');
                        const element = document.getElementById(id);
                        target.appendChild(element);
                    "
                    x-on:dragover.prevent="adding = true"
                    x-on:dragleave.prevent="adding = false"
                >
                    <h3>Group 5</h3>
                </ul>
            </div>
            
            <?php
            $chars = \App\Models\Characters\Character::where('company_id', 1)->get(); 
            ?>
            <ul class="character-list w-1/4" 
                x-on:drop="removing = false"
                x-on:drop.prevent="const id = event.dataTransfer.getData('text/plain');
                    const target = event.target.closest('ul');
                    const element = document.getElementById(id);
                    target.appendChild(element);
                "
                x-on:dragover.prevent="removing = true"
                x-on:dragleave.prevent="removing = false"
            >
                @foreach($chars as $char)
                    <li id="{{$char->name}}-list-item" class="p-2"
                        :class="{ 'bg-red-300': dragging }"
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
                        {{ $char->name }} - {{ $char->class->name }}
                    </li>
                @endforeach
            </ul>
        </div>
    </x-dashboard.section>
</x-layouts.dashboard>