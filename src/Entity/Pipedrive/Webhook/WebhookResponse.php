<?php

namespace App\Entity\Pipedrive\Webhook;

use Symfony\Component\Serializer\Attribute\SerializedName;

class WebhookResponse
{
    #[SerializedName(serializedName: 'status')]
    private string $status;

    #[SerializedName("data")]
    private array $webhooks;

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getWebhooks(): array
    {
        return $this->webhooks;
    }

    public function setWebhooks(array $webhooks): void
    {
        $this->webhooks = $webhooks;
    }

    public function addWebbook(Webhook $webhook): void
    {
        $this->webhooks[] = $webhook;
    }
}
