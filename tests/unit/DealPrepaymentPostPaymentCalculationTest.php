<?php

namespace App\Tests\unit;

use App\Entity\Pipedrive\Deal;
use App\Entity\Pipedrive\Field\EntityField;
use App\Entity\Pipedrive\Field\Field;
use App\Service\DealPaymentCalculator;
use PHPUnit\Framework\TestCase;

class DealPrepaymentPostPaymentCalculationTest extends TestCase
{
    private DealPaymentCalculator $dealPaymentCalculator;

    public function setUp(): void
    {
        $this->dealPaymentCalculator = new DealPaymentCalculator();
    }

    /**
     * @dataProvider postPaymentRestAmountCalculationDataProvider
     */
    public function testPostPaymentRestAmountCalculation(Deal $deal): void
    {
        $prePayment = $deal->getField(EntityField::prePaymentField);
        $postPayment = $deal->getField(EntityField::postPaymentField);

        if ($this->dealPaymentCalculator->isUnderPaid($deal)) {
            if ($prePayment->getValue() >= $postPayment->getValue()) {
                $restAmount = $deal->getValue() - ($prePayment->getValue() + $postPayment->getValue());
                $postPayment->setValue($postPayment->getValue() + $restAmount);
            }
        }

        $this->assertEquals(
            $deal->getValue(),
            ($prePayment->getValue() + $postPayment->getValue())
        );
    }

    /**
     * @dataProvider overPaymentCorrectionDataProvider
     */
    public function testOverPaymentCorrection(
        Deal $deal
    ): void
    {
        $prePayment = $deal->getField(EntityField::prePaymentField);
        $postPayment =  $deal->getField(EntityField::postPaymentField);

        if ($this->dealPaymentCalculator->isOverPaid($deal)) {
            $overPaid = ($prePayment->getValue() + $postPayment->getValue()) - $deal->getValue();

            if ($postPayment->getValue() >= $prePayment->getValue()) {
                $postPayment->setValue($postPayment->getValue() - $overPaid);
            } else {
                $prePayment->setValue($prePayment->getValue() - $overPaid);
            }
        }

        $this->assertEquals($deal->getValue(), $prePayment->getValue() + $postPayment->getValue());
    }

    public static function postPaymentRestAmountCalculationDataProvider(): array
    {
        return [
            [self::createDeal(10, 4, null)],
            [self::createDeal(100, 75, 10)],
            [self::createDeal(100, 100, null)],
            [self::createDeal(60, 0, null)],
        ];
    }

    public static function overPaymentCorrectionDataProvider(): array
    {
        return [
            [self::createDeal(20, 10, 25)],
            [self::createDeal(100, 90, 11)],
            [self::createDeal(40, 25.5, 77)],
            [self::createDeal(100, 100, 0)],
        ];
    }

    private static function createDeal($currentValue, $currentPrePayment, $currentPostPayment): Deal
    {
        $deal = new Deal(0, $currentValue);
        $prepaymentField = new Field(EntityField::prePaymentField->value, 'prepayment-foo', $currentPrePayment);
        $postPaymentField = new Field(EntityField::postPaymentField->value, 'postpayment-foo', $currentPostPayment);

        $deal->addField($prepaymentField);
        $deal->addField($postPaymentField);

        return $deal;
    }
}
