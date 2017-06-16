<?php

namespace api\modules\v1\matchEngine;

/**
 * MatchOne - matcher for one match
 *
 * This class provides the functions implementation for single return matcher
 *
 */
class MatchOne implements Matcher
{
    /**
     * Match
     * Returns an array with the best (single) match
     *
     * The compatibility ranges between 0 and 1
     *
     * @param item => item to be matched
     * @param itemList => possible matches
     *
     * @return object
     */
    public function match ($item, $itemList)
    {
        // Variable to store the match item
        $match = null;

        // This variable defines wich item in list has the best compatibility
        $bestCompatibility = 0;

        // Basic item definition
        $attributesCount = sizeof($item);

        // Run through array items
        foreach ($itemList as $key => $currentItem) {
            // Reset the current item compatibility
            $currentCompatibility = 0;

            /**
             * First of all: find out the item type to perform the correct match operation
             */
            if (is_string($currentItem)) {
                /**
                 * String comparation
                 * Compares each item attribute
                 * Compatibility receives the sum of attribute similarity
                 */
                for ($index = 0; $index < $attributesCount; $index++) {
                    $currentCompatibility += MatchComparatorString::compareAttribute($item[$index], $currentItem);
                }
            } else if (is_int($currentItem)) {
                /**
                 * Integer comparation
                 * Compares each item attribute
                 * Compatibility receives the sum of attribute similarity
                 */
                for ($index = 0; $index < $attributesCount; $index++) {
                    $currentCompatibility += MatchComparatorDiscrete::compareAttribute($item[$index], $currentItem);
                }
            } else if (is_float($currentItem)) {
                /**
                 * Float comparation
                 * Compares each item attribute
                 * Compatibility receives the sum of attribute similarity
                 */
                for ($index = 0; $index < $attributesCount; $index++) {
                    $currentCompatibility += MatchComparatorScalar::compareAttribute($item[$index], $currentItem);
                }
            } // Non defined type in match engine
            else {
                // TODO: trigger an exception
            }

            /**
             * Sum of attribute similarity between the items is divided by the number of attributes
             * It results in a number between 0 and 1 (%)
             */
            $currentCompatibility = $currentCompatibility / $attributesCount;

            // If the current item is the most compatible so far, it is saved in match
            if ($currentCompatibility > $bestCompatibility) {
                $bestCompatibility = $currentCompatibility;
                $match = $currentItem;
            }
        }

        // Return the match item
        return $match;
    }
}