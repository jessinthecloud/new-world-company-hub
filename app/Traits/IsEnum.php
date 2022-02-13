<?php

namespace App\Traits;

trait IsEnum
{
    // for dealing with dynamic names
    public static function valueFromName(string $name)
    {
        return defined(self::class."::$name") ? constant(self::class."::$name")->value : null;
    }

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
    
    public static function selectOptions(array $enums=null, array $selected=[]) : string
    {
        $enums ??= static::valueToAssociative();
        
        $options = '<option value=""></option>'."\n";
        foreach($enums as $value => $text) {
//            $options .= '<option value="'.$value.'">'.$text.'</option>';
            $options .= '<option value="'.$value.'"';
                if(in_array($value, $selected)){
                    $options .= ' SELECTED ';
                }
            $options .= '>'.$text.'</option>'."\n";
        }
        return $options;
    }
}