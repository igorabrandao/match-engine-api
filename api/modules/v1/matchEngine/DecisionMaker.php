<?php

namespace api\modules\v1\matchEngine;

/**
 * Decision Maker Interface
 *
 * This interface defines the match engine methods signature
 */
interface DecisionMaker
{
    /**
     * This method define the behavior of the system should the match be accepted
     *
     * @return mixed
     */
    public function acceptMatch();

    /**
     * This method define the behavior of the system should the match be rejected
     *
     * @return mixed
     */
    public function rejectMatch();
}