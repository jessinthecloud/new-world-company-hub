<?php

namespace App\Enums;

// bankable types
enum InventoryType : string
{
    case COMPANY = "GuildBank";
    case CHARACTER = "Inventory";
}