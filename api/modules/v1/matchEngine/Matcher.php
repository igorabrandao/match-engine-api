<?php

namespace api\modules\v1\matchEngine;

/**
 * Matcher - methods match compatibility definition
 *
 * This interface defines which matches will be presented to the user
 *
 */
interface Matcher
{
    /**
     * Match function
     * Compares an item with a list and returns an array of matches
     *
     * @param item => item to be matched
     * @param itemList => possible matches
     *
     * @return array
    */
    public function match($item, $itemsList);
}