<?php

namespace App\Entity\Pipedrive\Stage;

use App\Entity\Pipedrive\Deal;

class HogeWaarde extends AbstractStage
{
    public function __construct()
    {
        parent::__construct(8);
    }

    public function isApplicable(Deal $deal): bool
    {
        return $deal->getValue() > 50;
    }
}
