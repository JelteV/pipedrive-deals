<?php

namespace App\Tests\unit;

use PHPUnit\Framework\TestCase;

class DealStageMoverTest extends TestCase
{
    /**
     * @dataProvider moveDealToStageLageWaardeDataProvider
     */
    public function testMoveDealToStageLageWaarde(int|float $value, bool $expected): void
    {
        $moveToStageLageWaarde = $value > 0 && $value < 50;

        $this->assertEquals($moveToStageLageWaarde, $expected);
    }

    public static function moveDealToStageLageWaardeDataProvider()
    {
        return [
            [44, true],
            [0.00, false],
            [49.67, true],
            [-1, false],
            [0.01, true],
            [76, false],
            [4, true],
            [50, false]
        ];
    }
}
