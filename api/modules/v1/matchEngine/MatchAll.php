<?php

namespace api\modules\v1\matchEngine;

/**
 * MatcherAll - matcher for all items more than N% compatible
 *
 * This class provides the functions implementation for a multiple return matcher (non-fixed number of matches)
 *
 */

class MatcherAll implements Matcher
{
    /**
     * Defines the minimum item compatibility
     *
     * By default it is 0.7 or 70%
     *
     * Can be overwritten in class constructor
     */
    private $minimumCompatibility = 0.7;

    /**
     * @return int
     */
    public function getminimumCompatibility ()
    {
        return $this->minimumCompatibility;
    }

    /**
     * @param int $minimumCompatibility
     */
    public function setminimumCompatibility ($minimumCompatibility = null)
    {
        // Check if minimum compatibility parameter was informed
        if (!is_null($minimumCompatibility)) {
            $this->minimumCompatibility = $minimumCompatibility;
        }
    }

    /**
     * MatchMany constructor.
     *
     * @param $minimumCompatibility_
     */
    public function __construct ($minimumCompatibility_)
    {
        // Set how many matches the operation'll return
        $this->setminimumCompatibility($minimumCompatibility_);
    }

    /**
     * Match
     * Returns an array with the possible matches (above N% compatibility)
     *
     * The compatibility ranges between 0 and 1
     *
     * @param item => item to be matched
     * @param itemList => possible matches
     *
     * @return array
     */
    public function match ($item, $itemList)
    {
        // Array to store the match itens
        $matches = array();

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

            // Generate a multidimensional data to append
            $newItem = array(
                'item' => $currentItem,
                'compatibility' => $currentCompatibility
            );

            // Check if the current compatibility surpasses the minimum compatibility
            if ($currentCompatibility >= $this->getminimumCompatibility()) {
                // Add the list item and its compatibility to matches array
                array_push($matches, $newItem);
            }
        }

        // Return the matches array
        return $matches;
    }
}