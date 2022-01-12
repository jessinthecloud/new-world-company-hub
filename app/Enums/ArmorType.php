<?php

namespace App\Enums;

use App\Traits\HasClassConstants;

enum ArmorType : string
{
    use HasClassConstants; 
    
    case EquippableChest = "Chest";
    case EquippableHead = "Helmet";
    case EquippableHands = "Gloves";
    case EquippableLegs = "Pants";
    case EquippableFeet = "Shoes";
    case EquippableAmulet = "Amulet";
    case EquippableToken = "Earring";
    case EquippableRing = "Ring";
    case Bag = "Bag";
}