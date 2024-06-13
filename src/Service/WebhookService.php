<?php

namespace App\Service;

use App\Entity\Pipedrive\Webhook\Webhook;
use App\Entity\Pipedrive\Webhook\WebhookResponse;
use App\Serializer\WebhookNormalizer;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WebhookService extends AbstractWebService
{
    public function __construct(private readonly WebhookNormalizer $webhookNormalizer, private readonly SerializerInterface $serializer, HttpClientInterface $pipedriveClient)
    {
        parent::__construct($pipedriveClient);
    }

    public function findWebhookBySubscriptionUrl(string $subscriptionUrl): ?Webhook
    {
        $response = $this->pipedriveClient->request(Request::METHOD_GET, "/v1/webhooks/");
        $data = $this->serializer->deserialize($response->getContent(), WebhookResponse::class, 'json');

        $foundWebhook = null;

        foreach ($data->getWebhooks() as $item) {
            $webhook = $this->serializer->deserialize(json_encode($item), Webhook::class, 'json');

            if ($webhook->getSubscriptionUrl() == $subscriptionUrl) {
                $foundWebhook = $webhook;
                break;
            }
        }

        return $foundWebhook;
    }

    public function createWebhook(Webhook $webhook): ?Webhook
    {
        $data = $this->webhookNormalizer->normalize($webhook);
        $response = $this->pipedriveClient->request(Request::METHOD_POST, '/v1/webhooks', ['json' => $data]);

        return $response->getStatusCode() === 201
            ? $webhook
            : null;
    }
}
