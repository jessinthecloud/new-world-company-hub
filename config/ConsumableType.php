<?php

namespace App\Enums;

enum ConsumableType : string
{
    case FOOD = "Food";
    case OUTPOST_RUSH_FOOD = 'Outpost Rush Food';
    case OUTPOST_RUSH_POTIONS = 'Outpost Rush Potions';
    case POTION = "Potion";
    case RAW_FOOD = "Raw Food";
    case SIEGE_CONSUMABLES = 'Siege Consumables';
    case WEAPON_OIL = "Weapon Oil";
}