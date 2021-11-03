<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }

    public function class()
    {
        return $this->belongsTo(CharacterClass::class);
    }

    public function skills()
    {
        return $this->belongsToMany(CharacterClass::class);
    }
}