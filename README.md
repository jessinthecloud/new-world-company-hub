A bit too busy and friends using it aren't playing anymore so I doubt this will be updated further.

---

# Temp Overview 
A Laravel web app utilizing Laravel Livewire, Alpine, and Tailwind CSS to allow guilds from the game New World to organize their player roster and guild inventory outside the game.

The app utilizes livewire datatables and spatie's laravel roles and permissions, integrated with the Discord API via Laravel Socialite.

![Screenshot_33](https://user-images.githubusercontent.com/77401790/168481429-8f74fcbb-4b04-4039-bd04-f6eb7e52717a.png)

---
# Temp API example

# GET
## Base Weapons
### A listing of all base (not-instanced) weapons

```
https://breakpoint.company/api/v1/base-weapons
```
https://breakpoint.company/api/v1/base-weapons

#### Request
```
GET /api/v1/base-weapons HTTP/1.1
Host: breakpoint.company
```

#### Response

##### Body
```json
{
    "data": [
        {
            "id":1,
            "name":"A Terrible Echo",
            "json_id":"1hgauntletvoid_aterribleechot4",
            "slug":"voidgauntlet-a-terrible-echo-3-t4",
            "equip_type":"EquippableMainHand",
            "type":"VoidGauntlet",
            "description":"\"The wail carried through the mountains, silencing the birds\u2026and waking the horrors.\"",
            "tier":"4",
            "rarity":"3",
            "source":null,
            "required_level":null,
            "gear_score":"475",
            "min_gear_score":"400",
            "max_gear_score":"500",
            "icon":"lyshineui/images/icons/items/Weapon/2hVoidGauntletVinespunT4.png",
            "image":"lyshineui/images/icons/items_hires/2hVoidGauntletVinespunT4.png",
            "named":1,
            "num_perk_slots":0,
            "weight":42,
            "maxStack":1,
            "bindOnPickup":"0",
            "bindOnEquip":"1",
            "durability":2500,
            "flagCanBeBought":"0",
            "base_damage":"54",
            "stagger_damage":"39",
            "crit_chance":"0.02",
            "crit_multiplier":null,
            "created_at":null,
            "updated_at":null
        },
        {
            // another weapon
        },
        // more weapons...
    ]
}
```

##### Headers
`Content-Type` | `application/json`

---

### A paginated list of all base (not-instanced) weapons

Pagination defaults to 15 resources per page

```
https://breakpoint.company/api/v1/base-weapons?page={page_number}
```
https://breakpoint.company/api/v1/base-weapons?page=2

#### Request
```
GET /api/v1/base-weapons?page=2 HTTP/1.1
Host: breakpoint.company
```

#### Response

##### Body
```json
{
    "data": [
        {
            "id":1,
            "name":"A Terrible Echo",
            "json_id":"1hgauntletvoid_aterribleechot4",
            "slug":"voidgauntlet-a-terrible-echo-3-t4",
            "equip_type":"EquippableMainHand",
            "type":"VoidGauntlet",
            "description":"\"The wail carried through the mountains, silencing the birds\u2026and waking the horrors.\"",
            "tier":"4",
            "rarity":"3",
            "source":null,
            "required_level":null,
            "gear_score":"475",
            "min_gear_score":"400",
            "max_gear_score":"500",
            "icon":"lyshineui/images/icons/items/Weapon/2hVoidGauntletVinespunT4.png",
            "image":"lyshineui/images/icons/items_hires/2hVoidGauntletVinespunT4.png",
            "named":1,
            "num_perk_slots":0,
            "weight":42,
            "maxStack":1,
            "bindOnPickup":"0",
            "bindOnEquip":"1",
            "durability":2500,
            "flagCanBeBought":"0",
            "base_damage":"54",
            "stagger_damage":"39",
            "crit_chance":"0.02",
            "crit_multiplier":null,
            "created_at":null,
            "updated_at":null
        },
        {
            // another weapon
        },
        // more weapons...
    ],
    "links":{
        "first":"https://breakpoint.company/api/v1/base-weapons?page=1",
        "last":"https://breakpoint.company/api/v1/base-weapons?page=233",
        "prev":null,
        "next":"https://breakpoint.company/api/v1/base-weapons?page=2"
    },
    "meta":
    {
        "current_page":1,
        "from":1,
        "last_page":233,
        "links":[
            {"url":null, "label":"&laquo; Previous", "active":false},
            {"url":"https://breakpoint.company/api/v1/base-weapons?page=1", "label":"1", "active":true},
            {"url":"https://breakpoint.company/api/v1/base-weapons?page=2", "label":"2", "active":false},
            {"url":"https://breakpoint.company/api/v1/base-weapons?page=3", "label":"3", "active":false},
            {"url":"https://breakpoint.company/api/v1/base-weapons?page=4", "label":"4", "active":false},
            {"url":"https://breakpoint.company/api/v1/base-weapons?page=5", "label":"5", "active":false},
            {"url":"https://breakpoint.company/api/v1/base-weapons?page=6", "label":"6", "active":false},
            {"url":"https://breakpoint.company/api/v1/base-weapons?page=7", "label":"7", "active":false},
            {"url":"https://breakpoint.company/api/v1/base-weapons?page=8", "label":"8", "active":false},
            {"url":"https://breakpoint.company/api/v1/base-weapons?page=9", "label":"9", "active":false},
            {"url":"https://breakpoint.company/api/v1/base-weapons?page=10", "label":"10", "active":false},
            {"url":null, "label":"...", "active":false},
            {"url":"https://breakpoint.company/api/v1/base-weapons?page=232", "label":"232", "active":false},
            {"url":"https://breakpoint.company/api/v1/base-weapons?page=233", "label":"233", "active":false},
            {"url":"https://breakpoint.company/api/v1/base-weapons?page=2", "label":"Next &raquo;", "active":false}
        ],
        "path":"https://breakpoint.company/api/v1/base-weapons",
        "per_page":15,
        "to":15,
        "total":3495
    }
}
```

##### Headers
`Content-Type` | `application/json`

---

### Specific item by slug
```
https://breakpoint.company/api/v1/base-weapons/{slug}
```
https://breakpoint.company/api/v1/base-weapons/voidgauntlet-absolute-terror-4-t5

#### Path Variables
`slug` | `string` (Required) slug of the item, based on item name

#### Request
```
GET /api/v1/base-weapons/voidgauntlet-absolute-terror-4-t5 HTTP/1.1
Host: breakpoint.company
```

#### Response
##### Body 
```json
{
    "data": {
        "id":11,
        "name":"Absolute Terror",
        "json_id":"1hgauntletvoid_absoluteterrort5",
        "slug":"voidgauntlet-absolute-terror-4-t5",
        "equip_type":"EquippableMainHand",
        "type":"VoidGauntlet",
        "description":"\"You stare into the Void, the Void stares back.\"",        
        "tier":"5",
        "rarity":"4",
        "source":null,
        "required_level":null,
        "gear_score":null,
        "min_gear_score":"500",
        "max_gear_score":"600",
        "icon":"lyshineui/images/icons/items/Weapon/2hVoidGauntletAbyssalT5.png",
        "image":"lyshineui/images/icons/items_hires/2hVoidGauntletAbyssalT5.png",
        "named":1,
        "num_perk_slots":0,
        "weight":48,
        "maxStack":1,
        "bindOnPickup":"0",
        "bindOnEquip":"1",
        "durability":3000,
        "flagCanBeBought":"0",
        "base_damage":"54",
        "stagger_damage":"42",
        "crit_chance":"0.02",
        "crit_multiplier":null,
        "created_at":null,
        "updated_at":null
    }
}
```
##### Headers
`Content-Type` | `application/json`

---

### Specific item's possible perks
```
https://breakpoint.company/api/v1/base-weapons/{slug}/perks
```
https://breakpoint.company/api/v1/base-weapons/voidgauntlet-absolute-terror-4-t5/perks

#### Path Variables
`slug` | `string` (Required) slug of the item, based on item name

#### Request
```
GET /api/v1/base-weapons/voidgauntlet-absolute-terror-4-t5/perks HTTP/1.1
Host: breakpoint.company
```

#### Response
##### Body 
```json
{
    "data": [
        {
            "id":421,
            "name":"Repulsing Shield Bash",
            "json_id":"perkid_ability_shield_shieldbash",
            "slug":"repulsing-shield-bash",
            "description":"Shield Bash knocks back targets an additional ${25 * perkMultiplier}%.",
            "perk_type":"Generated",
            "tier":null,
            "rarity":null,
            "icon":"LyShineUI/Images/Icons/Perks/Brigand1.png",
            "image":null,
            "gear_score_scale":"0.00545",
            "min_gear_score":"100",
            "max_gear_score":"600",
            "condition":"OnActive",
            "created_at":null,
            "updated_at":null
        },
        {
            "id":291,
            "name":"Fortifying Shield Rush",
            "json_id":"perkid_ability_shield_shieldrush",
            "slug":"fortifying-shield-rush",
            "description":"After hitting a target with Shield Rush, gain Fortify, increasing damage absorption on self by ${5 * perkMultiplier}% for ${4} seconds.",
            "perk_type":"Generated",
            "tier":null,
            "rarity":null,
            "icon":"LyShineUI/Images/Icons/Perks/Brigand1.png",
            "image":null,
            "gear_score_scale":"0.00545",
            "min_gear_score":"100",
            "max_gear_score":"600",
            "condition":"OnActive",
            "created_at":null,
            "updated_at":null
        },            
        {
            "id":402,
            "name":"Refreshing",
            "json_id":"perkid_common_cdr",
            "slug":"refreshing",
            "description":"Reduces max cooldowns by ${1 * perkMultiplier}%.",
            "perk_type":"Generated",
            "tier":null,
            "rarity":null,
            "icon":"LyShineUI/Images/Icons/Perks/Resurge1.png",
            "image":null,
            "gear_score_scale":"0.00364",
            "min_gear_score":"100",
            "max_gear_score":"600",
            "condition":"OnEquip",
            "created_at":null,
            "updated_at":null
        }
    ]
}
```
##### Headers
`Content-Type` | `application/json`

