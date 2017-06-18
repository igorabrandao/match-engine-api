<?php

namespace api\modules\v1\matchEngine;

/**
 * DecisionMakerMany - DecisionMaker when there are is a limit for matches
 *
 * This class provides the functions implementation for decision maker with a fixed limit of matches (1 to N)
 */
class DecisionMakerMany implements DecisionMaker
{
    /**
     * Defines how many matches a item can be accepted
     *
     * By default it is the 3 best matches
     *
     * Can be overwritten in class constructor
     */
    private $maximumMatchesAccepted = 3;

    /**
     * Keeps the number of matches that have been accepted previously
     */
    private $currentMatchesAccepted = 0;

    /**
     * Keeps the item status.
     *
     * If set to TRUE, the item will appear as a possible match for others
     * otherwise it won't appear
     */
    private $itemStatus;

    /**
     * @return mixed
     */
    public function getMaximumMatchesAccepted ()
    {
        return $this->maximumMatchesAccepted;
    }

    /**
     * @param mixed $maximumMatchesAccepted
     */
    public function setMaximumMatchesAccepted ($maximumMatchesAccepted)
    {
        $this->maximumMatchesAccepted = $maximumMatchesAccepted;
    }

    /**
     * @return mixed
     */
    public function getCurrentMatchesAccepted ()
    {
        return $this->currentMatchesAccepted;
    }

    /**
     * @param mixed $currentMatchesAccepted
     */
    public function setCurrentMatchesAccepted ($currentMatchesAccepted)
    {
        $this->currentMatchesAccepted = $currentMatchesAccepted;
    }

    /**
     * @return mixed
     */
    public function getItemStatus ()
    {
        return $this->itemStatus;
    }

    /**
     * @param mixed $itemStatus
     */
    public function setItemStatus ($itemStatus)
    {
        $this->itemStatus = $itemStatus;
    }

    /**
     * DecisionMakerMany constructor.
     * @param null $maximumMatchesAccepted_
     */
    public function __construct ($maximumMatchesAccepted_ = null)
    {
        // Set the item default status
        $this->setitemStatus($this::WAITING_EVALUATION);

        // Check if matches number parameter was informed
        if (!is_null($maximumMatchesAccepted_)) {
            // Set how many matches can be accepted
            $this->setMaximumMatchesAccepted($maximumMatchesAccepted_);
        }
    }

    /**
     * N matches status definition function
     *
     * With the status set to ACCEPTED, an item will no longer appear as a possible match for the item that accepted it.
     * After acceptance, the item will be closed.
     *
     * It has a limitation related to ACCEPTED itens defined by $maximumMatchesAccepted attribute
     *
     * @param item => item or itemList to be matched
     * @param status => array with possible matches
     *
     * @return object array
     */
    public function decideMatch ($item, $status)
    {
        // Run through array items
        foreach ($item as $key => $currentItem) {
            // Decide wich status will be defined
            switch ($status[$key]) {
                case -1:
                    $this->setitemStatus($this::REJECTED);
                    break;
                case 0:
                    $this->setitemStatus($this::WAITING_EVALUATION);
                    break;
                case 1:

                    /**
                     * Rule: the max number of accepted matches should be respected
                     */
                    if ( $this->getCurrentMatchesAccepted() <= $this->getMaximumMatchesAccepted() ) {
                        $this->setitemStatus($this::ACCEPTED);

                        // Increment the number of accepted matches
                        $this->setCurrentMatchesAccepted($this->getCurrentMatchesAccepted() + 1);
                    }
                    /**
                     * If not, it's become a rejection
                     */
                    else {
                        $this->setitemStatus($this::REJECTED);
                    }

                    break;
                default:
                    $this->setitemStatus($this::STATUS_NOT_DEFINED);
                    break; // Needs to be handled
            }

            // Apply the status to the item
            $currentItem['status'] = $this->getitemStatus();
        }

        // Return the the item with the new attribute
        return $item;
    }
}