<?php

namespace App\Enums;

use App\Traits\HasClassConstants;

enum WeaponType : string
{
    use HasClassConstants;
    
    case Bow = "Bow";
    case FireStaff = "Fire Staff";
    case GreatAxe = "Great Axe";
    case Axe = "Axe";
    case Hatchet = "Hatchet";
//    case IceGauntlet = "Ice Gauntlet";
    case IceMagic = "Ice Gauntlet";
    case LifeStaff = "Life Staff";
    case Musket = "Musket";
    case Rapier = "Rapier";
    case Shield = "Shield";
    case Spear = "Spear";
    case Sword = "Sword";
    case VoidGauntlet = "Void Gauntlet";
    case WarHammer = "War Hammer";
}