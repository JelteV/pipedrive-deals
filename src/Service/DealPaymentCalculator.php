<?php

namespace App\Service;

use App\Entity\Pipedrive\Deal;
use App\Entity\Pipedrive\Field\EntityField;

class DealPaymentCalculator
{
    public function isUnderPaid(Deal $deal): bool
    {
        $currentDealValue = $deal->getValue();
        $currentPrePayment  = $deal->getField(EntityField::prePaymentField)->getValue();
        $currentPostPayment = $deal->getField(EntityField::postPaymentField)->getValue();

        $restAmount = $currentDealValue - ($currentPrePayment + $currentPostPayment);

        return $restAmount > 0;
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
