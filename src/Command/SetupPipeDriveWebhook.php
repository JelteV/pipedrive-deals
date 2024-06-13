<?php

namespace App\Command;

use App\Entity\Pipedrive\Webhook\Webhook;
use App\Service\UserService;
use App\Service\WebhookService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsCommand("pipedrive:webhook:configure")]
class SetupPipeDriveWebhook extends Command
{
    public function __construct(
        private readonly WebhookService $webhookService,
        private readonly UserService $userService,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly string $ngrokPublicUrl
    )
    {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $formatter = new SymfonyStyle($input, $output);
        $webhook = $this->webhookService->findWebhookBySubscriptionUrl($this->createSubscriptionUrl());

        if (!$webhook) {
            $newWebhookEntity = $this->buildWebhookEntity($this->createSubscriptionUrl());

            if ($this->webhookService->createWebhook($newWebhookEntity)) {
                $formatter->success("Create webhook: {$newWebhookEntity->getSubscriptionUrl()}");
            };
        } else {
            $formatter->success("webhook with subscription url: {$this->createSubscriptionUrl()} already exists");
        }

        return Command::SUCCESS;
    }

    private function buildWebhookEntity(
        string $subscriptionUrl,
        string $eventAction = "*",
        string $eventObject = "deal",
        string $version = '1.0'
    )
    {
        $webhook =  new Webhook();
        $webhook->setSubscriptionUrl($subscriptionUrl);
        $webhook->setEventAction($eventAction);
        $webhook->setEventObject($eventObject);
        $webhook->setVersion($version);
        $webhook->setUserId($this->userService->getCurrentUser()->getId());

        return $webhook;
    }

    private function createSubscriptionUrl(): string
    {
        return "{$this->ngrokPublicUrl}{$this->urlGenerator->generate('deal-notification')}";
    }
}
