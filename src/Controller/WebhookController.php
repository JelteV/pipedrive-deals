<?php

namespace App\Controller;

use App\Service\DealPaymentCalculator;
use App\Service\DealService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WebhookController extends AbstractController
{
    public function __construct(
        private readonly DealService           $dealService,
        private readonly DealPaymentCalculator $dealPaymentCalculator,
    ) {}

    #[Route('/webhook/deal/notification', name: 'deal-notification')]
    public function deal(Request $request): Response
    {
        $deal = $this->dealService->fromWebhookData($request->getContent());

        if ($this->dealPaymentCalculator->isOverPaid($deal)) {
            $deal = $this->dealPaymentCalculator->correctOverPayment($deal);
        } elseif ($this->dealPaymentCalculator->isUnderPaid($deal)) {
            $deal = $this->dealPaymentCalculator->correctUnderPayment($deal);
        }

        return new Response(200);
    }
}
