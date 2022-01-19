<?php

namespace App\Enums;

use App\Traits\HasClassConstants;
use App\Traits\IsEnum;

enum Rarity : string
{
    use HasClassConstants, IsEnum;
    
    case R1 = "Common";
    case R2 = "Uncommon";
    case R3 = "Rare";
    case R4 = "Epic";
    case R5 = "Legendary";

    public function color() : string
    {
        return match($this) 
        {
            Rarity::R1 => '#575750',
            Rarity::R2 => '#57A848',
            Rarity::R3 => '#217897',
            Rarity::R4 => '#B257B0',
            Rarity::R5 => '#FFA837',
        };
    }
}