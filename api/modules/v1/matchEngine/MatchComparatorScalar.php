<?php

namespace api\modules\v1\matchEngine;

/**
 * MatchComparatorScalar - match comparator scalar concrete class
 *
 * This class provides the functions implementation for scalar comparator
 *
 */
class MatchComparatorScalar implements MatchComparator
{
    /**
     * Function to compare two attributes and return its similarity
     * Returns a float between 0 and 1 representing the % of similarity
     * 
     * @param attrA => attribute 1
     * @param attrB => attribute 2
     * 
     * @return float
     */
    public static function compareAttribute($attrA, $attrB)
    {
        // Calculates the distance between the attributes
        $difference = abs($attrA - $attrB);
    
        // Calculates the similarity without weigth for each value fraction
        $compatibility = ($difference / $attrA);
        
        // Returns the compatibility between the attributes
        return (1 - $compatibility);
    }
}