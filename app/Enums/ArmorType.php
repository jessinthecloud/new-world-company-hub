<?php

namespace App\Enums;

enum ArmorType : string
{
    case Chest = "EquippableChest";
    case Helmet = "EquippableHead";
    case Gloves = "EquippableHands";
    case Pants = "EquippableLegs";
    case Shoes = "EquippableFeet";
    case Amulet = "EquippableAmulet";
    case Earring = "EquippableToken";
    case Ring = "EquippableRing";
    case Bag = "Bag";
}