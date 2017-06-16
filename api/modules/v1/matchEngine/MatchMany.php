<?php

namespace api\modules\v1\matchEngine;

/**
 * MatchMany - match N items
 *
 * This class provides the functions implementation for a multiple return matcher (fixed number of matches)
 *
 */

class MatchMany implements Matcher
{
    /**
     * Defines how many matches'll be returned
     *
     * By default it is the 3 best matches
     *
     * Can be overwritten in class constructor
     */
    private $matchNumber = 3;

    /**
     * @return int
     */
    public function getmatchNumber ()
    {
        return $this->matchNumber;
    }

    /**
     * @param int $matchNumber
     */
    public function setmatchNumber ($matchNumber)
    {
        $this->matchNumber = $matchNumber;
    }

    /**
     * MatchMany constructor.
     *
     * @param $matchNumber_
     */
    public function __construct ($matchNumber_)
    {
        // Check if matches number parameter was informed
        if (!is_null($matchNumber_)) {
            // Set how many matches the operation'll return
            $this->setmatchNumber($matchNumber_);
        }
    }

    /**
     * Match
     * Returns an array with N matches (accordling to parameter)
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

            // Add the list item and its compatibility to matches array
            array_push($matches, $newItem);
        }

        // Sort the matches array by compatibility desc
        usort($matches, function ($a, $b) {
            if ($a['compatibility'] == $b['compatibility']) return 0;
            return $a['compatibility'] < $b['compatibility'] ? 1 : -1;
        });

        // Return the match array limited by matchNumber parameter
        return array_slice($matches, 0, $this->getmatchNumber());
    }
}