<?php

namespace App\Entity\Pipedrive;

use App\Entity\Pipedrive\Field\EntityField;
use App\Entity\Pipedrive\Field\Field;
use App\Entity\Pipedrive\Stage\StageFactory;
use App\Entity\Pipedrive\Stage\StageInterface;

class Deal
{
    private array $fields = [];

    public function __construct(private readonly int $id, private mixed $value, private readonly string $status)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getStage(): StageInterface
    {
        return StageFactory::fromDeal($this);
    }

    public function addField(Field $field): self
    {
        if (!array_key_exists($field->getId(), $this->fields)) {
            $this->fields[$field->getId()] = $field;
        }

        return $this;
    }

    public function getField(EntityField $entityField): ?Field
    {
        return $this->fields[$entityField->value] ?? null;
    }

    public function getFields(): array
    {
        return $this->fields;
    }
}
