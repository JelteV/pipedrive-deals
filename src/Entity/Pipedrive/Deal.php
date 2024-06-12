<?php

namespace App\Entity\Pipedrive;

use App\Entity\Pipedrive\Field\Field;

class Deal
{
    private int $id;

    private $value;

    private array $fields = [];

    public function __construct(int $id, mixed $value)
    {
        $this->id = $id;
        $this->value = $value;
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

    public function addField(Field $field): self
    {
        if (!array_key_exists($field->getKey(), $this->fields)) {
            $this->fields[$field->getKey()] = $field;
        }

        return $this;
    }
}
