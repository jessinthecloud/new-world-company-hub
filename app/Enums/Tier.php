<?php

namespace App\Enums;

use App\Traits\HasClassConstants;

enum Tier : string
{
    use HasClassConstants;
    
    case T1 = "Tier I";
    case T2 = "Tier II";
    case T3 = "Tier III";
    case T4 = "Tier IV";
    case T5 = "Tier V";
}