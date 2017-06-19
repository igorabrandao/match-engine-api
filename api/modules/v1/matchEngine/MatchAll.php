<?php

namespace api\modules\v1\matchEngine;

use api\helpers\StringHelper;

/**
 * MatcherAll - matcher for all items more than N% compatible
 *
 * This class provides the functions implementation for a multiple return matcher (non-fixed number of matches)
 *
 */

class MatchAll implements Matcher
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
    public function setminimumCompatibility ($minimumCompatibility)
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
    public function __construct ($minimumCompatibility_ = null)
    {
        // Check if minimum compatibility parameter was informed
        if (!is_null($minimumCompatibility_)) {
            $this->minimumCompatibility = $minimumCompatibility_;
        }
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

            echo "<br>===============================================================<br>";

            // Run through the properties of each item
            foreach ($currentItem as $listLabel => $listProperty) {

                // Run through the properties of each item
                foreach ($item as $itemLabel => $itemProperty) {

                    // Returns a value between 0 and 1 representing the attribute weight
                    $attributeWeight = StringHelper::string_compare($itemLabel, $listLabel);

                    // If the value is a numeric string, converts to a numeric variable
                    if (is_numeric($itemProperty)) {
                        $itemProperty = $itemProperty + 0;
                    }

                    if (is_numeric($listProperty)) {
                        $listProperty = $listProperty + 0;
                    }

                    echo gettype($itemProperty) . ": {[ " . $itemLabel . "] => " .
                        $itemProperty . ', [' . $listLabel . "] => " . $listProperty .
                        "} = [weight] => " . $attributeWeight;

                    /**
                     * First of all: find out the item type to perform the correct match operation
                     */
                    if (is_string($itemProperty)) {
                        /**
                         * String comparation
                         * Compares each item attribute
                         * Compatibility receives the sum of attribute similarity
                         *
                         * Receive the attribute similarity and multiply by its weight
                         */
                        $currentCompatibility += (MatchComparatorString::compareAttribute($itemProperty, $listProperty) * $attributeWeight);
                    } else if (is_int($itemProperty)) {
                        /**
                         * Integer comparation
                         * Compares each item attribute
                         * Compatibility receives the sum of attribute similarity
                         *
                         * Receive the attribute similarity and multiply by its weight
                         */
                        $currentCompatibility += (MatchComparatorDiscrete::compareAttribute($itemProperty, $listProperty) * $attributeWeight);
                    } else if (is_float($itemProperty)) {
                        /**
                         * Float comparation
                         * Compares each item attribute
                         * Compatibility receives the sum of attribute similarity
                         *
                         * Receive the attribute similarity and multiply by its weight
                         */
                        $currentCompatibility += (MatchComparatorScalar::compareAttribute($itemProperty, $listProperty) * $attributeWeight);
                    } // Non defined type in match engine
                    else {
                        // TODO: trigger an exception
                    }

                    echo ", [compatibility] => " . $currentCompatibility . "<br>";
                }
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

            echo "<br>XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX<br>";
            echo " item compatibility: " . $currentCompatibility . "<br>";
            echo "<br>XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX<br>";
        }

        // Return the matches array
        return $matches;
    }
}