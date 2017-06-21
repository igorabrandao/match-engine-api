<?php
/**
 * Created by PhpStorm.
 * User: igorbrandao
 * Date: 20/06/17
 * Time: 05:44
 */

namespace api\modules\v1\matchEngine;

/**
 * DecisionMakerStrategy - context decision maker strategy class
 *
 * Defines which decision strategy will be used
 *
 */
class DecisionMakerStrategy
{
    /**
     * Represents the strategy itself
     *
     * @var StrategyStars|null
     */
    private $strategy = NULL;

    /**
     * DecisionMakerStrategy constructor.
     * @param $itemsList
     * @param null $maximumMatchesAccepted_
     */
    public function __construct ($itemsList, $maximumMatchesAccepted_ = null)
    {
        // Base on parameters, choose which strategy it'll be applied
        if (!is_null($maximumMatchesAccepted_)) {
            // Set DecisionMakerMany strategy
            $this->strategy = new DecisionMakerMany($maximumMatchesAccepted_);
        }
        else if (sizeof($itemsList) > 1 && is_null($maximumMatchesAccepted_)) {
            // If it's a 1->N relation, choose DecisionMakerAll by default
            $this->strategy = new DecisionMakerAll();
        }
        else {
            $this->strategy = new DecisionMakerOne();
        }
    }

    /**
     * DecisionMaker
     * Calls the strategy DecisionMaker function as defined in class constructor
     *
     * @param item => item or itemList to be matched
     * @param status => item status
     *
     * @return object
     */
    public function decideMatch($item, $status)
    {
        return $this->strategy->decideMatch($item, $status);
    }
}