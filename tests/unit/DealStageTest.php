<?php

namespace App\Tests\unit;

use App\Entity\Pipedrive\Deal;
use App\Entity\Pipedrive\Stage\BinnenKomendeDeals;
use App\Entity\Pipedrive\Stage\HogeWaarde;
use App\Entity\Pipedrive\Stage\LageWaarde;
use App\Entity\Pipedrive\Stage\StageInterface;
use PHPUnit\Framework\TestCase;

class DealStageTest extends TestCase
{
    /**
     * @dataProvider moveDealToStageLageWaardeDataProvider
     */
    public function testCorrectDealStage(Deal $deal, StageInterface $expectedStage): void
    {
        $this->assertEquals($deal->getStage(), $expectedStage);
    }

    public static function moveDealToStageLageWaardeDataProvider()
    {
        return [
            [new Deal(0, 44), new LageWaarde()],
            [new Deal(0, 0.00), new BinnenKomendeDeals()],
            [new Deal(0, 49.67), new LageWaarde()],
            [new Deal(0, -1), new BinnenKomendeDeals()],
            [new Deal(0, 0.01),  new LageWaarde()],
            [new Deal(0, 76),  new HogeWaarde],
            [new Deal(0, 9999), new HogeWaarde()],
            [new Deal(0, 50), new BinnenKomendeDeals()]
        ];
    }
}
