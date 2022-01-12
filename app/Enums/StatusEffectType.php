<?php

namespace App\Enums;

use App\Traits\HasClassConstants;

enum StatusEffectType : string
{
    use HasClassConstants;
    
    case AFFLICTION = "Affliction";
    case AI_NEUTRAL = "Ai_neutral";
    case ATTRIBUTES = "Attributes";
    case AZOTHSTAFF = "Azoth Staff";
    case BLEED = "Bleed";
    case BOOST = "Boost";
    case BOSSDEBUFF = "Boss Debuff";
    case BUFF = "Buff";
    case BURN = "Burn";
    case CC = "Cc";
    case CLEANSE = "Cleanse";
    case DEBILITATE = "Debilitate";
    case DEBUFF = "Debuff";
    case DEFBOOST = "Def Boost";
    case DISEASE = "Disease";
    case DOT = "Dot";
    case EMPOWER = "Empower";
    case ESSENCERUPTURE = "Essence Rupture";
    case ESSENCERUPTURET1 = "Essence Rupture Tier I";
    case ESSENCERUPTURET2 = "Essence Rupture Tier II";
    case ESSENCERUPTURET3 = "Essence Rupture Tier III";
    case EXHAUST = "Exhaust";
    case FAMILY = "Family";
    case FOCUS = "Focus";
    case FOODINITIALRECOVERY = "Food Initial Recovery";
    case FORTIFY = "Fortify";
    case FREEZE = "Freeze";
    case FROST = "Frost";
    case FROSTBITE = "Frostbite";
    case FROSTBUFF = "Frost Buff";
    case GATHERBOOST = "Gather Boost";
    case HARVESTHP = "Harvest HP";
    case HARVESTMANA = "Harvest Mana";
    case HASTE = "Haste";
    case HEAL = "Heal";
    case HUNTERVISION = "Hunter Vision";
    case ICEROOT = "Iceroot";
    case IMMORTAL = "Immortal";
    case INSMOKE = "Insmoke";
    case LASTSTAND = "Last Stand";
    case LIFESTAFFBUFF = "Lifestaff Buff";
    case NONDISPELLABLEDEBUFF = "Non-Dispellable Debuff";
    case NULLCHAMBERBUFF = "Null Chamber Buff";
    case POISON = "Poison";
    case POWDERBURN = "Powderburn";
    case RECOVERY = "Recovery";
    case REMOVAL = "Removal";
    case REND = "Rend";
    case RESISTBOOST = "Resist Boost";
    case RESISTTINCTURE = "Resist Tincture";
    case ROOT = "Root";
    case SHOCK = "Shock";
    case SHOWERROOT = "Shower Root";
    case SIEGEONLY = "Siege Only";
    case SILENCE = "Silence";
    case SLOW = "Slow";
    case SLOWANDSTUN = "Slow and Stun";
    case SPEAR = "Spear";
    case STAMINA = "Stamina";
    case STUN = "Stun";
    case THREAT = "Threat";
    case THROWINGAXE = "Throwing Axe";
    case TIMER = "Timer";
    case TRADESKILL = "Tradeskill";
    case TRAPPER = "Trapper";
    case TRAVERSALHASTE = "Traversal Haste";
    case UNINTERRUPTIBLE = "Uninterruptible";
    case VOIDGAUNTLET = "Void Gauntlet";
    case WARHAMMER = "War Hammer";
    case WEAKEN = "Weaken";
}