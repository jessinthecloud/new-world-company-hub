<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface InventoryItem
{
    public function owner();
    
    public function scopeSimilarSlugs(Builder $query, string $slug);
}