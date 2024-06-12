<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractWebService
{
    public function __construct(protected HttpClientInterface $pipedriveClient) {}
}
