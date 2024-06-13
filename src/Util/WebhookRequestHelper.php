<?php

namespace App\Util;

use Symfony\Component\HttpFoundation\Request;

class WebhookRequestHelper
{
    public static function getFieldFromRequest(string $block, string $element, Request $request): mixed
    {
        $data = $request->toArray();

        return $data[$block][$element] ?? null;
    }
}
