<?php

namespace App\Services;

use App\Contracts\InventoryItemContract;
use App\Models\Items\BaseItem;

interface ItemServiceContract
{
    public function baseItemsOptions() : string;

    public function itemTypeOptions(  ) : string;

    public function getAllBaseItems() : array;
    
    public function createUniqueSlug(array $fields) : string;
    
    public function createItem(array $validated, BaseItem $base=null);

    public function baseItem(string $slug) : BaseItem;
}