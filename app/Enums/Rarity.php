<?php

namespace App\Enums;

use App\Traits\HasClassConstants;
use App\Traits\IsEnum;

enum Rarity : string
{
    use HasClassConstants, IsEnum;
    
    case R1 = "Common";
    case R2 = "Uncommon";
    case R3 = "Rare";
    case R4 = "Epic";
    case R5 = "Legendary";
}