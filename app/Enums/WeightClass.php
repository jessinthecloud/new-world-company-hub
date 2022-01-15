<?php

namespace App\Enums;

use App\Traits\HasClassConstants;
use App\Traits\IsEnum;

enum WeightClass : string
{
    use HasClassConstants, IsEnum;
    
    case Light = "Light";
    case Medium = "Medium";
    case Heavy = "Heavy";
}