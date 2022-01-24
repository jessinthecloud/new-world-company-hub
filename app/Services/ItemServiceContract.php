<?php

namespace App\Services;

use App\Contracts\InventoryItem;
use App\Models\Items\BaseItem;

interface ItemServiceContract
{
    public function baseItemsOptions(InventoryItem $item=null) : string;

    public function itemTypeOptions(string $itemType='') : string;

    public function getAllBaseItems() : array;
    
    public function createUniqueSlug(array $fields) : string;

    public function initItemAttributes( array $validated, BaseItem $base=null );
    
    public function createItem(array $validated, BaseItem $base=null);

    public function baseItemBySlug(string $slug) : ?BaseItem;
}