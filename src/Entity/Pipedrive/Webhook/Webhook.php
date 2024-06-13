<?php

namespace App\Entity\Pipedrive\Webhook;

use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

class Webhook
{
    private int $id = 0;
    #[SerializedName(serializedName: 'event_action')]
    #[Groups(['create'])]
    private string $eventAction;
    #[SerializedName(serializedName: 'event_object')]
    #[Groups(['create'])]
    private string $eventObject;
    #[SerializedName(serializedName: 'subscription_url')]
    #[Groups(['create'])]
    private string $subscriptionUrl;

    #[SerializedName(serializedName: 'user_id')]
    #[Groups(['create'])]
    private int $userId;

    #[Groups(['create'])]
    private string $version;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEventAction(): string
    {
        return $this->eventAction;
    }

    public function setEventAction(string $eventAction): void
    {
        $this->eventAction = $eventAction;
    }

    public function getEventObject(): string
    {
        return $this->eventObject;
    }

    public function setEventObject(string $eventObject): void
    {
        $this->eventObject = $eventObject;
    }

    public function getSubscriptionUrl(): string
    {
        return $this->subscriptionUrl;
    }

    public function setSubscriptionUrl(string $subscriptionUrl): void
    {
        $this->subscriptionUrl = $subscriptionUrl;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function setVersion(string $version): void
    {
        $this->version = $version;
    }
}
