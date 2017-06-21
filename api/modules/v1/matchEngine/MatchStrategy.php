<?php
/**
 * Created by PhpStorm.
 * User: igorbrandao
 * Date: 20/06/17
 * Time: 05:44
 */

namespace api\modules\v1\matchEngine;

/**
 * MatchStrategy - context match strategy class
 *
 * Defines which match strategy will be used
 *
 */
class MatchStrategy
{
    /**
     * Represents the strategy itself
     *
     * @var StrategyStars|null
     */
    private $strategy = NULL;

    /**
     * MatchStrategy constructor.
     * @param $itemsList
     * @param null $matchNumber_
     * @param null $minimumCompatibility_
     */
    public function __construct ($itemsList, $matchNumber_ = null, $minimumCompatibility_ = null)
    {
        // Base on parameters, choose which strategy it'll be applied
        if (!is_null($matchNumber_)) {
            // Set MatchMany strategy
            $this->strategy = new MatchMany($matchNumber_);
        }
        else if (!is_null($minimumCompatibility_)) {
            // Set MatchAll strategy
            $this->strategy = new MatchAll($minimumCompatibility_);
        }
        else if (sizeof($itemsList) > 1) {
            // If it's a 1->N relation, choose MatchAll by default
            $this->strategy = new MatchAll();
        }
        else {
            $this->strategy = new MatchOne();
        }
    }

    /**
     * Match
     * Calls the strategy match function as defined in class constructor
     *
     * @param item => item to be matched
     * @param itemList => possible matches
     *
     * @return object
     */
    public function match($item, $itemsList)
    {
        return $this->strategy->match($item, $itemsList);
    }
}