<?php

namespace App\Enums;

enum PerkSource : string
{
    case GEM = "Gem";
    case GENERATED = "Generated";
    case ATTRIBUTE = "Attribute";
}