<x-layouts.dashboard>
    <x-dashboard.section
        :title="'War Board'"
    >
        <div class="board-wrapper flex flex-wrap w-full">
            <div class="war-board flex-grow mr-4 border border-black">
    
                <!-- drop target -->
                <ul class="war-group drop-target">
                </ul>
                
                <!-- drop target -->
                <ul class="war-group drop-target">
                </ul>
                
                <!-- drop target -->
                <ul class="war-group drop-target">
                </ul>
                
                <!-- drop target -->
                <ul class="war-group drop-target">
                </ul>
                
                <!-- drop target -->
                <ul class="war-group drop-target">
                </ul>
            </div>
            
            <?php
            $chars = \App\Models\Characters\Character::where('company_id', 1)->get(); 
            ?>
            <ul class="character-list w-1/4">
                @foreach($chars as $char)
                    <li class="p-2" draggable="true">{{ $char->name }} - {{ $char->class->name }}</li>
                @endforeach
            </ul>
        </div>
        
        
    </x-dashboard.section>
</x-layouts.dashboard>