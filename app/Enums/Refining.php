<?php

namespace App\Enums;

use App\Traits\HasClassConstants;
use App\Traits\IsEnum;

enum Refining
{
    use HasClassConstants, IsEnum;
    
    case LEATHERWORKING;
    case SMELTING;
    case STONECUTTING;
    case WEAVING;
    case WOODWORKING;
}