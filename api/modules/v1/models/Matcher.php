<?php

namespace api\modules\v1\models;

/**
 * Matcher - methods match compatibility definition
 *
 * This interface defines which matches will be presented to the user
 *
 */
interface Matcher
{
    /*!
     * Match
     * Returns an array of matches
     * 
     * @param item => item to be matched
     * @param itemList => possible matches
     *
     * return array
     *
     * @since 0.1
     * @access public
    */
    public function match($item, $itemsList);
}