<?php

namespace App\Service;

use App\Entity\Pipedrive\Stage\StageFactory;
use App\Util\WebhookRequestHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NoteService extends AbstractWebService
{
    public function __construct(HttpClientInterface $pipedriveClient)
    {
        parent::__construct($pipedriveClient);
    }

    public function addDealNoteStageChanged(Request $request): void
    {
        $dealId = (int) WebhookRequestHelper::getFieldFromRequest('current', 'id', $request);
        $currentStage = StageFactory::getById(
            (int) WebhookRequestHelper::getFieldFromRequest('current', 'stage_id', $request)
        );
        $previousStage = StageFactory::getById(
            (int) WebhookRequestHelper::getFieldFromRequest('previous', 'stage_id', $request)
        );

        $this->pipedriveClient->request(
            Request::METHOD_POST,
            '/v1/notes',
            [
                'json' => [
                    'deal_id' => $dealId,
                    'content' => sprintf(
                        "Deal moved from stage: %s(%d) to %s(%d) source: pipedrive-deals",
                        $previousStage->getLabel(),
                        $previousStage->getStageId(),
                        $currentStage->getLabel(),
                        $currentStage->getStageId()
                    )
                ]
            ]
        );
    }
}
