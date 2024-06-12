<?php

namespace App\Serializer;

use App\Entity\Pipedrive\Field\Field;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class FieldDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $fieldData = json_decode($data);

        return new Field(
            $fieldData->data->id,
            $fieldData->data->key
        );
    }


    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === Field::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [Field::class];
    }
}
