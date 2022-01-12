<?php

namespace App\Enums;

use App\Traits\HasClassConstants;

enum Refining
{
    use HasClassConstants;
    
    case LEATHERWORKING;
    case SMELTING;
    case STONECUTTING;
    case WEAVING;
    case WOODWORKING;
}