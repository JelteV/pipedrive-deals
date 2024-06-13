<?php

namespace App\Service;

use App\Entity\Pipedrive\Deal;
use App\Entity\Pipedrive\Field\EntityField;
use App\Util\WebhookRequestHelper;
use Symfony\Component\HttpFoundation\Request;

class DealChangeDetector
{
    public function hasChangedPaymentDetails(Request $request, Deal $deal): bool
    {
        $prePaymentField = $deal->getField(EntityField::prePaymentField);
        $postPaymentField = $deal->getField(EntityField::postPaymentField);

        $currentPrePaymentValue = WebhookRequestHelper::getFieldFromRequest('current', $prePaymentField->getKey(), $request);
        $previousPrePaymentValue = WebhookRequestHelper::getFieldFromRequest('previous', $prePaymentField->getKey(), $request);

        $currentPostPaymentValue = WebhookRequestHelper::getFieldFromRequest('current', $postPaymentField->getKey(), $request);
        $previousPostPaymentValue = WebhookRequestHelper::getFieldFromRequest('previous', $postPaymentField->getKey(), $request);

        return $currentPrePaymentValue !== $previousPrePaymentValue || $currentPostPaymentValue !== $previousPostPaymentValue;
    }

    public function hasChangedDealValue(Request $request): bool
    {
        $currentDealValue = WebhookRequestHelper::getFieldFromRequest( 'current', 'value', $request);
        $previousDealValue = WebhookRequestHelper::getFieldFromRequest('previous', 'value', $request);

        return $currentDealValue !== $previousDealValue;
    }

    public function hasChangedDealStatus(Request $request): bool
    {
        $currentStatus = WebhookRequestHelper::getFieldFromRequest('current', 'status', $request);
        $previousStatus = WebhookRequestHelper::getFieldFromRequest('previous', 'status', $request);

        return $currentStatus !== $previousStatus;
    }

    public function hasChangedDealStage(Request $request): bool
    {
        $currentStageId = WebhookRequestHelper::getFieldFromRequest('current', 'stage_id', $request);
        $previousStageId = WebhookRequestHelper::getFieldFromRequest( 'previous', 'stage_id', $request);

        return $currentStageId !== $previousStageId;
    }
}
