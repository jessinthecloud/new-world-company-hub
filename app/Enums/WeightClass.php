<?php

namespace App\Enums;

use App\Traits\HasClassConstants;

enum WeightClass : string
{
    use HasClassConstants;
    
    case Light = "Light";
    case Medium = "Medium";
    case Heavy = "Heavy";
}