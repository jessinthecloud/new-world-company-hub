<?php

namespace App\Enums;

use App\Traits\HasClassConstants;

enum Rarity : string
{
    use HasClassConstants;
    
    case R1 = "Common";
    case R2 = "Uncommon";
    case R3 = "Rare";
    case R4 = "Epic";
    case R5 = "Legendary";
}