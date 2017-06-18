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
     * Itens status
     * By default it starts with WAITING_EVALUATION
     */
    const STATUS_NOT_DEFINED    = -1;
    const WAITING_EVALUATION    = 0;
    const REJECTED              = 1;
    const ACCEPTED              = 2;

    /**
     * This method defines the match status accordling parameter
     *
     * @param item => item or itemList to be matched
     * @param status => possible matches
     *
     * @return mixed
     */
    public function decideMatch($item, $status);
}