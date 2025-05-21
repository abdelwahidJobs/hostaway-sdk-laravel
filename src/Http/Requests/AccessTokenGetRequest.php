<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

class AccessTokenGetRequest extends HostAwayRequest
{
    public function __construct(string $client_id, string $client_secret)
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'cache-control' => 'no-cache'
        ];
        parent::__construct('POST', '/v1/accessTokens', $headers, $this->buildBody($client_id, $client_secret));
    }

    public function buildBody($client_id, $client_secret): string
    {
        return "grant_type=client_credentials&client_id=$client_id&client_secret=$client_secret&scope=general";
    }
}
