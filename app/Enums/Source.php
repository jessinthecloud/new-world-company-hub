<?php

namespace App\Enums;

use App\Traits\HasClassConstants;
use App\Traits\IsEnum;

enum Source : string
{    
    use HasClassConstants, IsEnum;
    
    case CRAFTING = "Crafting";
    case QUEST = "Quest";
    case SHOP = "Shop";
    case OTHER = "Other";
}