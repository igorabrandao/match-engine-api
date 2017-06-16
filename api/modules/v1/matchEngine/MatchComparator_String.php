<?php

namespace api\modules\v1\matchEngine;

use api\helpers\StringHelper;

/**
 * MatchComparatorDiscrete - match comparator string concrete class
 *
 * This class provides the functions implementation for textual comparator
 *
 */
class MatchComparatorString implements MatchComparator
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
        // Calculares the similarity between string an return the result in %
        return StringHelper::string_compare($attrA, $attrB);
    }
}