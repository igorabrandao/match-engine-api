<?php

namespace api\modules\v1\matchEngine;

/**
 * DecisionMakerOne
 * This class is responsible for handle only one match acceptance or rejection
 *
 * It provides the functions implementation defined in DecisionMaker interface
 * for decision maker with at most 1 (one) accepted match per item (1 to 1)
 */
class DecisionMakerOne implements DecisionMaker
{
    /**
     * Keeps the item status.
     *
     * If set to TRUE, the item will appear as a possible match for others.
     */
    private $itemStatus;

    /**
     * @return mixed
     */
    public function getitemStatus ()
    {
        return $this->itemStatus;
    }

    /**
     * @param mixed $itemStatus
     */
    public function setitemStatus ($itemStatus)
    {
        $this->itemStatus = $itemStatus;
    }

    /**
     * DecisionMaker_One constructor.
     */
    public function __construct ()
    {
        // Set the item default status
        $this->setitemStatus($this::WAITING_EVALUATION);
    }

    /**
     * Single match status definition function
     *
     * With the status set to ACCEPTED, an item will no longer appear as a possible match for the item that accepted it.
     * After acceptance, the item will be closed.
     *
     * @param item => item or itemList to be matched
     * @param status => possible matches
     *
     * @return object
     */
    public function decideMatch ($item, $status)
    {
        // Decide wich status will be defined
        switch ($status) {
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
        $item['status'] = $this->getitemStatus();

        // Return the the item with the new attribute
        return $item;
    }
}