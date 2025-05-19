<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

use GuzzleHttp\Psr7\Utils;
use Backend\HostawaySdkLaravel\Dto\CustomField;

class CustomFieldCreateRequest extends HostAwayRequest
{
    public function __construct(CustomField $customField)
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'cache-control' => 'no-cache'
        ];

        $payload = new CustomFieldBody($customField);
        $body = Utils::streamFor((string)$payload);
        parent::__construct('POST', '/v1/customFields?provider=wechalet', $headers, $body);
    }
}
