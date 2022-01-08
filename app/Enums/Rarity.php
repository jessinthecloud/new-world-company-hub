<?php

namespace App\Enums;

enum Rarity : string
{
    case COMMON = "Common";
    case UNCOMMON = "Uncommon";
    case RARE = "Rare";
    case EPIC = "Epic";
    case LEGENDARY = "Legendary";
}