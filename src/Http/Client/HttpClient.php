<?php

namespace Backend\HostawaySdkLaravel\Http\Client;

use Backend\HostawaySdkLaravel\Http\Requests\HostAwayRequest;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

interface HttpClient
{
    /**
     * Send The http request.
     *
     * @param HostAwayRequest $request
     * @return ResponseInterface
     * @throws GuzzleException
     * @throws RequestException
     */
    public function send(HostAwayRequest $request): ResponseInterface;
}
