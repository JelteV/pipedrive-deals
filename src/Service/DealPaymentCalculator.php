<?php

namespace App\Service;

use App\Entity\Pipedrive\Deal;
use App\Entity\Pipedrive\Field\EntityField;

class DealPaymentCalculator
{
    public function correctUnderPayment(Deal $deal): Deal
    {
        $prePayment = $deal->getField(EntityField::prePaymentField);
        $postPayment = $deal->getField(EntityField::postPaymentField);

        if ($prePayment->getValue() >= $postPayment->getValue()) {
            $restAmount = $deal->getValue() - ($prePayment->getValue() + $postPayment->getValue());
            $postPayment->setValue($postPayment->getValue() + $restAmount);
        } elseif ($postPayment->getValue() >= $prePayment->getValue()) {
            $restAmount = $deal->getValue() - ($prePayment->getValue() + $postPayment->getValue());
            $prePayment->setValue($postPayment->getValue() + $restAmount);
        }

        return $deal;
    }

    public function isUnderPaid(Deal $deal): bool
    {
        $currentDealValue = $deal->getValue();
        $currentPrePayment  = $deal->getField(EntityField::prePaymentField)->getValue();
        $currentPostPayment = $deal->getField(EntityField::postPaymentField)->getValue();

        $restAmount = $currentDealValue - ($currentPrePayment + $currentPostPayment);

        return $restAmount > 0;
    }

    public function correctOverPayment(Deal $deal): Deal
    {
        $prePayment  = $deal->getField(EntityField::prePaymentField);
        $postPayment = $deal->getField(EntityField::postPaymentField);
        $overPaid = $prePayment->getValue() + $postPayment->getValue() - $deal->getValue();

        if ($postPayment >= $prePayment) {
            $postPayment->setValue($postPayment->getValue() - $overPaid);
        } else {
            $prePayment->setValue($prePayment->getValue() - $overPaid);
        }

        return $deal;
    }

    public function isOverPaid(Deal $deal): bool
    {
        $currentDealValue = $deal->getValue();
        $currentPrePayment  = $deal->getField(EntityField::prePaymentField)->getValue();
        $currentPostPayment = $deal->getField(EntityField::postPaymentField)->getValue();

        $restAmount = ($currentPrePayment + $currentPostPayment) - $currentDealValue;

        return $restAmount > 0;
    }
}
