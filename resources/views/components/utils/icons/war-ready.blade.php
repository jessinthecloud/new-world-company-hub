@props(['loadout'])

@if($loadout?->approved()) <div {{ $attributes->merge(['class' => 'text-green-500 flex justify-center items-center']) }}><x-utils.icons.checkmark/></div> @endif