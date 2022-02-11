@props(['loadout'])

@if($loadout->approved()) <span {{ $attributes->merge(['class' => 'ml-2 text-green-500']) }}><x-utils.icons.checkmark/></span> @endif