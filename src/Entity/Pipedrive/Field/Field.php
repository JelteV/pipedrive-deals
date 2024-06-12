<?php

namespace App\Entity\Pipedrive\Field;

class Field
{
    private mixed $value;

    public function __construct(private readonly int $id, private readonly string $key, $default_value)
    {
        $this->value = $default_value;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }
}
