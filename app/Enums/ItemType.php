<?php

namespace App\Enums;

use App\Traits\HasClassConstants;
use App\Traits\IsEnum;

enum ItemType : string
{
    use HasClassConstants, IsEnum;

    case ARMOR = "Armor";
    case WEAPON = "Weapon";

}