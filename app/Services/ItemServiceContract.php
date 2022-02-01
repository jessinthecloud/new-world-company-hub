<?php

namespace App\Services;

use App\Contracts\InventoryItemContract;
use App\Models\Items\BaseItem;

interface ItemServiceContract
{
    public function baseItemsOptions(InventoryItemContract $item=null) : string;

    public function itemTypeOptions(string $itemType) : string;

    public function getAllBaseItems() : array;
    
    public function createUniqueSlug(array $fields) : string;

    public function initItemAttributes( array $validated, BaseItem $base=null );
    
    public function createSpecificItem(array $validated, BaseItem $base=null);

    public function baseItemBySlug(string $slug) : ?BaseItem;
}