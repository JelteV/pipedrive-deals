<?php

namespace App\Entity\Pipedrive\User;

use Symfony\Component\Serializer\Attribute\SerializedName;

class UserResponse
{
    #[SerializedName(serializedName: 'status')]
    private string $status;

    #[SerializedName("data")]
    private array $user;

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getUser(): array
    {
        return $this->user;
    }

    public function setUser(array $users): void
    {
        $this->user = $users;
    }
}
