<?php

namespace App\Tests\unit;

use PHPUnit\Framework\TestCase;

class DealPrepaymentPostPaymentCalculationTest extends TestCase
{
    /**
     * @dataProvider postPaymentRestAmountCalculationDataProvider
     */
    public function testPostPaymentRestAmountCalculation(float $currentDealValue, ?float $currentPrePayment, ?float $currentPostPayment): void
    {
        $currentPrepayment = !is_null($currentPrePayment) ? $currentPrePayment : 0.00;
        $currentPostPayment = !is_null($currentPostPayment) ? $currentPostPayment : 0.00;

        $restAmount = $currentDealValue - ($currentPrepayment + $currentPostPayment);

        $newPrePayment = $currentPrepayment;
        $newPostPayment = $currentPostPayment;

        if ($restAmount > 0) {
            if ($currentPrepayment >= $currentPostPayment) {
                $newPostPayment += $restAmount;
            }
        }

        $this->assertEquals($currentDealValue, ($newPrePayment + $newPostPayment));
    }

    /**
     * @dataProvider overPaymentCorrectionDataProvider
     */
    public function testOverPaymentCorrection(
        float $currentDealValue,
        float $currentPrepayPayment,
        float $currentPostPayment
    ): void
    {
        $overPaidAmount = ($currentPrepayPayment + $currentPostPayment) - $currentDealValue;

        $newPrePayment = $currentPrepayPayment;
        $newPostPayment = $currentPostPayment;

        if ($overPaidAmount > 0) {
            if ($currentPostPayment >= $currentPrepayPayment) {
                $newPostPayment -= $overPaidAmount;
            } else {
                $newPrePayment -= $overPaidAmount;
            }
        }

        $this->assertEquals($currentDealValue, ($newPrePayment + $newPostPayment));
    }

    public static function postPaymentRestAmountCalculationDataProvider(): array
    {
        return [
            [10, 4, null],
            [100, 75, 10],
            [100, 100, null],
            [60, 0, null],
        ];
    }

    public static function overPaymentCorrectionDataProvider(): array
    {
        return [
            [20, 10, 25],
            [100, 90, 11],
            [40, 25.5, 77],
            [100, 100, 0]
        ];
    }
}
