<?php

namespace App\Service;

use App\Entity\Pipedrive\Field\Field;
use App\Serializer\FieldDenormalizer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FieldService extends AbstractWebService
{
    public function __construct(
        HttpClientInterface                $pipedriveClient,
        private readonly FieldDenormalizer $fieldDenormalizer,
        private readonly FieldsEntity      $fieldsEntity = FieldsEntity::Deal
    )
    {
        parent::__construct($pipedriveClient);
    }

    public function findById(int $id): Field
    {
        $response = $this->pipedriveClient->request("GET", $this->createPath($id));

        return $this->fieldDenormalizer->denormalize($response->getContent(), Field::class);
    }

    private function createPath(int $id): string
    {
        return "/v1/{$this->fieldsEntity->value}/{$id}";
    }
}
