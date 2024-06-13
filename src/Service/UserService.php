<?php

namespace App\Service;

use App\Entity\Pipedrive\User\User;
use App\Entity\Pipedrive\User\UserResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserService extends AbstractWebService
{
    public function __construct(private readonly SerializerInterface $serializer, HttpClientInterface $pipedriveClient)
    {
        parent::__construct($pipedriveClient);
    }

    public function getCurrentUser(): ?User
    {
        $response = $this->pipedriveClient->request(Request::METHOD_GET, "/v1/users/me");
        $data = $this->serializer->deserialize($response->getContent(), UserResponse::class, 'json');

        $foundUser = null;
        $user = $this->serializer->deserialize(json_encode($data->getUser()), User::class, 'json');

        if (!empty($user->getId()) && !empty($user->getName())) {
            $foundUser = $user;
        }

        return $foundUser;
    }
}
