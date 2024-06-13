<?php

namespace App\Service;

use App\Entity\Pipedrive\Deal;
use App\Entity\Pipedrive\Field\EntityField;
use Symfony\Component\HttpFoundation\Request;

class DealChangeDetector
{
    public function hasChangedPaymentDetails(Request $request, Deal $deal): bool
    {
        $prePaymentField = $deal->getField(EntityField::prePaymentField);
        $postPaymentField = $deal->getField(EntityField::postPaymentField);

        $currentPrePaymentValue = $this->getValue($request->toArray(), 'current', $prePaymentField->getKey());
        $previousPrePaymentValue = $this->getValue($request->toArray(), 'previous', $prePaymentField->getKey());

        $currentPostPaymentValue = $this->getValue($request->toArray(), 'current', $postPaymentField->getKey());
        $previousPostPaymentValue = $this->getValue($request->toArray(), 'previous', $postPaymentField->getKey());

        return $currentPrePaymentValue !== $previousPrePaymentValue || $currentPostPaymentValue !== $previousPostPaymentValue;
    }

    public function hasChangedDealValue(Request $request): bool
    {
        $currentDealValue = $this->getValue($request->toArray(), 'current', 'value');
        $previousDealValue = $this->getValue($request->toArray(), 'previous', 'value');

        return $currentDealValue !== $previousDealValue;
    }

    public function hasChangedDealStatus(Request $request): bool
    {
        $currentStatus = $this->getValue($request->toArray(), 'current', 'status');
        $previousStatus = $this->getValue($request->toArray(), 'previous', 'status');

        return $currentStatus !== $previousStatus;
    }

    public function hasChangedDealStage(Request $request): bool
    {
        $currentStageId = $this->getValue($request->toArray(), 'current', 'stage_id');
        $previousStageId = $this->getValue($request->toArray(), 'previous', 'stage_id');

        return $currentStageId !== $previousStageId;
    }

    private function getValue(array $data, string $block, string $element): mixed
    {
        return $data[$block][$element];
    }
}
