<?php

namespace App\Entity\Pipedrive\Stage;

use App\Entity\Pipedrive\Deal;
use App\Entity\Pipedrive\Status\Status;

class GewonnenDeals extends AbstractStage
{
    public function __construct()
    {
        parent::__construct(9);
    }

    public function isApplicable(Deal $deal): bool
    {
        return $deal->getStatus() == Status::won->value;
    }
}
