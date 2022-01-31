<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface InventoryItemContract
{
    public function owner();
    
    public function scopeSimilarSlugs(Builder $query, string $slug);
}