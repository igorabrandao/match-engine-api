<?php

namespace api\modules\v1\matchEngine;

/**
 * DecisionMakerMany - DecisionMaker when there are is a limit for matches
 *
 * This class provides the functions implementation for decision maker with no limit of matches (1 to N)
 */
class DecisionMakerAll implements DecisionMaker
{
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
     */
    public function __construct ()
    {
        // Set the item default status
        $this->setitemStatus($this::WAITING_EVALUATION);
    }

    /**
     * N matches status definition function
     *
     * With the status set to ACCEPTED, an item will no longer appear as a possible match for the item that accepted it.
     * After acceptance, the item will be closed.
     *
     * There is no limitation related to ACCEPTED itens
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
                    $this->setitemStatus($this::ACCEPTED);
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