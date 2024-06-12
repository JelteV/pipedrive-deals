<?php

namespace App\Entity\Pipedrive\Stage;

use App\Entity\Pipedrive\Deal;

abstract class AbstractStage implements StageInterface
{
    public function __construct(private readonly int $stageId) {}

    public function getStageId(): int
    {
        return $this->stageId;
    }

    abstract public function isApplicable(Deal $deal): bool;
}
