<?php

namespace App\Enums;

enum ArmorType : string
{
    case CHEST = "EquippableChest";
    case HELMET = "EquippableHead";
    case GLOVES = "EquippableHands";
    case PANTS = "EquippableLegs";
    case SHOES = "EquippableFeet";
    case AMULET = "EquippableAmulet";
    case EARRING = "EquippableToken";
    case RING = "EquippableRing";
    case BAG = "Bag";
}