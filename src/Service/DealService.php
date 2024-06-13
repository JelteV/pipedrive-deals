<?php

namespace App\Service;

use App\Entity\Pipedrive\Deal;
use App\Entity\Pipedrive\Field\EntityField;
use App\Entity\Pipedrive\Field\Field;
use App\Serializer\DealDenormalizer;
use App\Serializer\DealNormalizer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DealService
{
    public function __construct(
        private readonly HttpClientInterface $pipedriveClient,
        private readonly FieldService $fieldService,
        private readonly DealChangeDetector $dealChangeDetector,
        private readonly DealDenormalizer $dealDenormalizer,
        private readonly DealNormalizer $dealNormalizer
    ) {}

    public function fromWebhookData(Request $request): Deal
    {
        $data = $request->getContent();
        $deal = $this->dealDenormalizer->denormalize($request->getContent(), Deal::class);

        $this->populateFields(
            $data,
            $deal,
            [
                $this->fieldService->findById(EntityField::prePaymentField->value),
                $this->fieldService->findById(EntityField::postPaymentField->value)
            ]
        );

        return $deal;
    }

    public function hasProcessableChanges(Request $request): bool
    {
        $deal = $this->fromWebhookData($request);

        return $this->dealChangeDetector->hasChangedPaymentDetails($request, $deal)
            || $this->dealChangeDetector->hasChangedDealValue($request)
            || $this->dealChangeDetector->hasChangedDealStatus($request);
    }

    public function update(Deal $deal)
    {
        $data = $this->dealNormalizer->normalize($deal);
        $this->pipedriveClient->request(
            'PUT',
            "/v1/deals/{$deal->getId()}",
            ['json' => $data]
        );
    }

    private function populateFields($data, Deal $deal, $fields): void
    {
        $dealData = json_decode($data);

        /** @var Field $field */
        foreach ($fields as $field) {
            $key = $field->getKey();
            $field->setValue($dealData->current->$key);
            $deal->addField($field);
        }
    }
}
