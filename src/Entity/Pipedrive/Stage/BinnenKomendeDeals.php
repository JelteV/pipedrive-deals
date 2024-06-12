<?php

namespace App\Entity\Pipedrive\Stage;

use \App\Entity\Pipedrive\Deal;

class BinnenKomendeDeals extends AbstractStage
{
    public function __construct()
    {
        parent::__construct(1);
    }


    public function isApplicable(Deal $deal): bool
    {
        return $deal->getValue() <= 0;
    }
}
