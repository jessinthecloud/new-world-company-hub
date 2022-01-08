<?php

namespace App\Enums;

enum PerkType
{
    case BLOCK;
    case CRITICAL;
    case HEALTH;
    case LUCK;
    case MANA;
    case STAMINA;
    case TOOL;
}