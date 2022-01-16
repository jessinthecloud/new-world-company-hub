<?php //dump($armor); ?>
<div class="relative tooltip-wrapper">
    <div id="pop-up" class="tooltip">
        <div class="relative">
            <h1>{{ $armor->name }}</h1>
            @if(!empty($armor->base->iconUrl()))
                <img src="{{ $armor->base->iconUrl() }}" alt="{{ $armor->description }}">
            @endif
            <p>{{ $armor->description }}</p>
        </div>
    </div>
</div>

