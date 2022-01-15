<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuildBank extends Model
{
    protected $guarded = [];
    
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [];

    public function weapons()
    {
        
    }
    
    public function armor()
    {
        
    }   

    public function company()
    {
        
    }
}