<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WebhookController extends AbstractController
{
    public function __construct(private readonly LoggerInterface $logger) {}

    #[Route('/webhook/deal/notification', name: 'deal-notification')]
    public function deal(Request $request): Response
    {
        $this->logger->debug($request->getContent());

        return new Response();
    }

}
