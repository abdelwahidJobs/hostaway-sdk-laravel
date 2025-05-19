<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

class ConversationsGetRequest extends HostAwayRequest
{
    public function __construct(ConversationsGetRequestBody $requestBody)
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'cache-control' => 'no-cache'
        ];

        $uri = '/v1/conversations?provider=wechalet&' . $requestBody->getQuery();
        parent::__construct('GET', $uri, $headers);
    }
}

