<?php

namespace App\Enums;

use App\Traits\HasClassConstants;
use App\Traits\IsEnum;

enum ArmorType : string
{
    use HasClassConstants, IsEnum; 
    
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