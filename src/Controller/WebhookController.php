<?php

namespace App\Controller;

use App\Service\DealPaymentCalculator;
use App\Service\DealService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WebhookController extends AbstractController
{
    public function __construct(
        private DealService $dealService,
        private DealPaymentCalculator $dealPaymentCalculator
    ) {}

    #[Route('/webhook/deal/notification', name: 'deal-notification')]
    public function deal(Request $request): Response
    {
        $deal = $this->dealService->fromWebhookData($request->getContent());

        dump($deal, $this->dealPaymentCalculator->isUnderPaid($deal));
        exit;


        return new Response(200);
    }
}
