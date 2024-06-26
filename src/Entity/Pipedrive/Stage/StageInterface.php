<?php

namespace App\Entity\Pipedrive\Stage;

use App\Entity\Pipedrive\Deal;

interface StageInterface
{
    public function getStageId(): int;

    public function getLabel(): string;

    public function isApplicable(Deal $deal): bool;
}
