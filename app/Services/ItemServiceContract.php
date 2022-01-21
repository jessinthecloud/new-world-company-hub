<?php

namespace App\Services;

use App\Contracts\InventoryItemContract;

interface ItemServiceContract
{
    public function baseItemsOptions() : string;

    public function itemTypeOptions(  ) : string;

    public function getAllBaseItems() : array;
    
    public function createUniqueSlug(array $fields) : string;
}