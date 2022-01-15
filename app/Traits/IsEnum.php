<?php

namespace App\Traits;

trait IsEnum
{
    public static function getAllValues() : array
    {
        return array_map(
            fn(self $that) => $that->value, 
            self::cases()
        );
    }
    
    public static function getAllNames() : array
    {
        return array_map(
            fn(self $that) => $that->name, 
            self::cases()
        );
    }
    
    /*
     * Get single dimension associative array of name => value
     */
    public static function toAssociative() : array
    {
        return array_merge(...array_map(
            fn(self $that) => [$that->name => $that->value], 
            self::cases()
        ));
    }
    
    /*
     * Get single dimension associative array of value => value
     */
    public static function valueToAssociative() : array
    {
        return array_merge(...array_map(
            fn(self $that) => [$that->value => $that->value], 
            self::cases()
        ));
    }
}