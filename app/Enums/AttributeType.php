<?php

namespace App\Enums;

use App\Traits\HasClassConstants;
use App\Traits\IsEnum;

enum AttributeType : string
{
    use HasClassConstants, IsEnum;
    
    case CON = "Constitution";
    case DEX = "Dexterity";
    case FOC = "Focus";
    case STR = "Strength";
    case INT = "Intelligence";
}