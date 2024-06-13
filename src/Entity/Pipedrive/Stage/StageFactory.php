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
