<?php

namespace App\Entity\Pipedrive\Stage;

use App\Entity\Pipedrive\Deal;

class LageWaarde extends AbstractStage
{
    public function __construct()
    {
        parent::__construct(7);
    }

    public function isApplicable(Deal $deal): bool
    {
        return $deal->getValue() > 0 && $deal->getValue() < 50;
    }

    public function getLabel(): string
    {
        return 'Lage waarde';
    }
}
