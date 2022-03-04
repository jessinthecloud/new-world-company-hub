<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/** @deprecated */
interface InventoryContract
{
    public function items() : Collection;
    
    public function owner() : Model;
}
