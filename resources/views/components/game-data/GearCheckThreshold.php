<?php

use App\Enums\Rarity;
use App\Traits\HasClassConstants;
use App\Traits\IsEnum;

enum GearCheckThreshold : int
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
    case VeryLow = 545; // >= 545 <= 595
    case Low = 596; // >= 596 <= 599
    case Acceptable = 600; // >= 600 <= 609
    case Good = 610; // >= 610 <= 619
    case Excellent = 620; // and up
    
    public function color($score) : string
    {
        return match(true) 
        {
            // Very Low
            $score <= GearCheckThreshold::Low && $score >= GearCheckThreshold::VeryLow => '#575750',
            // Low
            $score <= GearCheckThreshold::Acceptable && $score >= GearCheckThreshold::Low => '#57A848',
            // Acceptable
            $score <= GearCheckThreshold::Good && $score >= GearCheckThreshold::Acceptable => '#217897',
            // Good
            $score <= GearCheckThreshold::Excellent && $score >= GearCheckThreshold::Good => '#B257B0',
            // Excellent
            $score >= GearCheckThreshold::Excellent => '#FFA837',
            default => '#FF0000', // Fail
        };
    }
    
    public function rating($score) : string
    {
        return $score >= GearCheckThreshold::VeryLow;
    }
}