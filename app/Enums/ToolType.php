<?php

namespace App\Enums;

use App\Traits\HasClassConstants;
use App\Traits\IsEnum;

enum ToolType : string
{
    use HasClassConstants, IsEnum;
    
    case LOGGING_AXE = "Logging Axe";
    case SKINNING_KNIFE = "Skinning Knife";
    case SICKLE = "Sickle";
    case PICKAXE = "Pickaxe";
    case FISHING_POLE = "Fishing Pole";
    case AZOTH_STAFF = "Azoth Staff"; 
}