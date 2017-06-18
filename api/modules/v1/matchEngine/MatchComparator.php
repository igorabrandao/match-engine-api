<?php

namespace api\modules\v1\matchEngine;

/**
 * MatchComparator - methods match definition
 *
 * This interface defines which methods each match comparator instance should have
 *
 */
interface MatchComparator
{
    /**
     * Compares two attributes
     * Returns a float between 0 and 1 representing the % of similarity
     * 
     * @param attrA => attribute 1
     * @param attrB => attribute 2
     *
     * return float (between 0 and 1)
    */
    public static function compareAttribute($attrA, $attrB);
}