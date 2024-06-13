<?php

namespace App\Entity\Pipedrive\Stage;

use App\Entity\Pipedrive\Deal;

class StageFactory
{
    public static function fromDeal(Deal $deal): StageInterface
    {
        /** @var StageInterface $stage */
        foreach (static::getStages() as $stage) {
            if ($stage->isApplicable($deal)) {
                return $stage;
            }
        }

        return new BinnenKomendeDeals();
    }

    public static function getById(int $stageId): ?StageInterface
    {
        $foundStage = null;

        /** @var StageInterface $stage */
        foreach (static::getStages() as $stage) {
            if ($stage->getStageId() === $stageId) {
                $foundStage = $stage;
                break;
            }
        }

        return $foundStage;
    }

    private static function getStages(): array
    {
        return [
            new GewonnenDeals(),
            new BinnenKomendeDeals(),
            new LageWaarde(),
            new HogeWaarde()
        ];
    }
}
