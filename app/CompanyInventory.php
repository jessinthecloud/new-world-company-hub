<?php

namespace App;

use App\Models\Companies\Company;

class CompanyInventory extends Models\Items\InventoryItem
{
    protected $table = 'inventory_items';
    protected string $ownerable_type = Company::class;
}