<?php

namespace App\Serializer;

use App\Entity\Pipedrive\Deal;
use App\Entity\Pipedrive\Field\Field;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class DealNormalizer implements NormalizerInterface
{
    /**
     * @param Deal $object
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        $data = ['stage_id' => $object->getStage()->getStageId()];

        /** @var Field $field */
        foreach ($object->getFields() as $field) {
            $data[$field->getKey()] = $field->getValue();
       }

       return $data;
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Deal;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [Deal::class => true];
    }
}
