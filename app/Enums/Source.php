<?php

namespace App\Enums;

use App\Traits\HasClassConstants;

enum Source : string
{    
    use HasClassConstants;
    
    case CRAFTING = "Crafting";
    case QUEST = "Quest";
    case SHOP = "Shop";
    case OTHER = "Other";
}