<?php

namespace App\Serializer;

use App\Entity\Pipedrive\Webhook\Webhook;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class WebhookNormalizer implements NormalizerInterface
{
    /**
     * @param Webhook $object
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        $data = [
            'id' => $object->getId(),
            'event_action' => $object->getEventAction(),
            'event_object' => $object->getEventObject(),
            'user_id' => $object->getUserId(),
            'version' => $object->getVersion(),
            'subscription_url' => $object->getSubscriptionUrl()
        ];

        return $data;
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Webhook;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [Webhook::class => true];
    }
}
