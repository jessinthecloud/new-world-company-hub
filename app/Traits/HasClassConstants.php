<?php

namespace App\Traits;

trait HasClassConstants
{
    public static function fromName(string $name)
    {
        return defined(self::class."::$name") ? constant(self::class."::$name") : null;
    }

    public static function getAllValues()
    {
        return array_map(
            fn(self $that) => $that->value, 
            self::cases()
        );
    }
    
    public static function getAllNames()
    {
        return array_map(
            fn(self $that) => $that->name, 
            self::cases()
        );
    }
    
    public static function toAssociative()
    {
        return array_map(
            fn(self $that) => [$that->name => $that->value], 
            self::cases()
        );
    }
}