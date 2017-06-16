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
     * This method define how the match should be accepted
     *
     * @return mixed
     */
    public function acceptMatch();

    /**
     * This method define how the match should be rejected
     *
     * @return mixed
     */
    public function rejectMatch();
}