<?php

namespace App\Enums;

enum Source : string
{
    case CRAFTING = "Crafting";
    case QUEST = "Quest";
    case SHOP = "Shop";
    case OTHER = "Other";
}