<?php

namespace api\modules\v1\matchEngine;

/**
 * MatchComparatorDiscrete - match comparator discrete concrete class
 *
 * This class provides the functions implementation for discrete comparator
 *
 */
class MatchComparatorDiscrete implements MatchComparator
{
    /**
     * Function to compare two attributes and return its similarity
     * Returns a float between 0 and 1 representing the % of similarity
     * 
     * @param attrA => attribute 1
     * @param attrB => attribute 2
     * 
     * @return int
     */
    public static function compareAttribute($attrA, $attrB)
    {
        // Perform a direct comparation
        if ($attrA == $attrB) {
            return 1;
        }
        else {
            return 0;
        }
    }
}