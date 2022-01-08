<?php

namespace App\Enums;

enum PerkType : string
{
    case BLOCK = "Block";
    case CRITICAL = "Critical";
    case HEALTH = "Health";
    case LUCK = "Luck";
    case MANA = "Mana";
    case STAMINA = "Stamina";
    case TOOL = "Tool";
}