<?php

namespace App\Tests\unit;

use App\Entity\Pipedrive\Deal;
use App\Entity\Pipedrive\Stage\BinnenKomendeDeals;
use App\Entity\Pipedrive\Stage\GewonnenDeals;
use App\Entity\Pipedrive\Stage\HogeWaarde;
use App\Entity\Pipedrive\Stage\LageWaarde;
use App\Entity\Pipedrive\Stage\StageInterface;
use App\Entity\Pipedrive\Status\Status;
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
            [new Deal(0, 44, Status::open->value), new LageWaarde()],
            [new Deal(0, 0.00, Status::lost->value), new BinnenKomendeDeals()],
            [new Deal(0, 49.67, Status::open->value), new LageWaarde()],
            [new Deal(0, -1, Status::lost->value), new BinnenKomendeDeals()],
            [new Deal(0, 0.01, Status::open->value),  new LageWaarde()],
            [new Deal(0, 76, Status::lost->value),  new HogeWaarde],
            [new Deal(0, 9999, Status::open->value), new HogeWaarde()],
            [new Deal(0, 50, Status::lost->value), new BinnenKomendeDeals()],
            [new Deal(0, 0.00, Status::won->value), new GewonnenDeals()],
            [new Deal(0, 44, Status::won->value), new GewonnenDeals()],
            [new Deal(0, 9999, Status::won->value), new GewonnenDeals()],
        ];
    }
}
