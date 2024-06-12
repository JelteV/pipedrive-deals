<?php

namespace App\Serializer;

use App\Entity\Pipedrive\Deal;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class DealDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Deal
    {
        $dealData = json_decode($data);

        return new Deal($dealData->current->id, $dealData->current->value);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === Deal::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [Deal::class];
    }
}
