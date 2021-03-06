<?php

namespace App\Enums;

use App\Traits\HasClassConstants;
use App\Traits\IsEnum;

enum GearCheckThreshold: int
{
    use HasClassConstants, IsEnum;

    // number is the low end of++ the range
    /**
     * X 0 - 544 Too Low
     * 545-595 Very Low
     * 596-599 Low
     * 600-609 Acceptable
     * 610-619 Good
     * 620-625 Excellent
     */
    case TooLow = 0;    // >= 545 <= 595
    case VeryLow = 545;    // >= 545 <= 595
    case Low = 596;        // >= 596 <= 599
    case Acceptable = 600; // >= 600 <= 609
    case Good = 610;       // >= 610 <= 619
    case Excellent = 620;  // and up

    /**
     * Determine gear rating color
     *
     * @param $score
     *
     * @return string
     */
    public static function color( $score ) : string
    {
        return match ( true ) {
            // Very Low
            $score < GearCheckThreshold::Low->value && $score >= GearCheckThreshold::VeryLow->value => '#575750',
            // Low
            $score < GearCheckThreshold::Acceptable->value && $score >= GearCheckThreshold::Low->value => '#57A848',
            // Acceptable
            $score < GearCheckThreshold::Good->value && $score >= GearCheckThreshold::Acceptable->value => '#217897',
            // Good
            $score < GearCheckThreshold::Excellent->value && $score >= GearCheckThreshold::Good->value => '#B257B0',
            // Excellent
            $score >= GearCheckThreshold::Excellent->value => '#FFA837',
            default => '#FF0000', // Fail
        };
    }
    
    /**
     * Determine threshold name based on gear score
     *
     * @param $score
     *
     * @return string
     */
    public static function getName( $score ) : string
    {
        return match ( true ) {
            // Very Low
            $score < GearCheckThreshold::Low->value && $score >= GearCheckThreshold::VeryLow->value => 'VeryLow',
            // Low
            $score < GearCheckThreshold::Acceptable->value && $score >= GearCheckThreshold::Low->value => 'Low',
            // Acceptable
            $score < GearCheckThreshold::Good->value && $score >= GearCheckThreshold::Acceptable->value => 'Acceptable',
            // Good
            $score < GearCheckThreshold::Excellent->value && $score >= GearCheckThreshold::Good->value => 'Good',
            // Excellent
            $score >= GearCheckThreshold::Excellent->value => 'Excellent',
            default => 'TooLow', // Fail
        };
    }

    /**
     * Determine if the gear score is high enough to pass the ready check
     *
     * @param $score
     *
     * @return bool
     */
    public static function passes( $score ) : bool
    {
        return $score >= GearCheckThreshold::VeryLow->value;
    }
}