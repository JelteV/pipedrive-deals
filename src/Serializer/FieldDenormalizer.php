<?php

namespace App\Serializer;

use App\Entity\Pipedrive\Field\EntityField;
use App\Entity\Pipedrive\Field\Field;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class FieldDenormalizer implements DenormalizerInterface
{
    private const DEFAULT_NUMERIC_VALUE = 0.00;
    private const DEFAULT_VALUE = null;

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Field
    {
        $fieldData = json_decode($data);

        $fieldId = $fieldData->data->id;

        return new Field(
            $fieldId,
            $fieldData->data->key,
            $this->getDefaultValue($fieldId)
        );
    }

    private function getDefaultValue(int $fieldId): mixed
    {
        $number_default = $fieldId == EntityField::prePaymentField->value
            || $fieldId == EntityField::postPaymentField->value;


        return $number_default ? static::DEFAULT_NUMERIC_VALUE : static::DEFAULT_VALUE;
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
