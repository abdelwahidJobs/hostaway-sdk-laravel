<?php

namespace Backend\HostawaySdkLaravel\Http\Client;

use Backend\HostawaySdkLaravel\Http\Environment\Environment;
use Backend\HostawaySdkLaravel\Http\Requests\HostAwayRequest;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class HostAwayHttpClient implements HttpClient
{
    protected Environment $environment;

    protected Client $client;

    /**
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
        $this->client = new Client([
            'base_uri' => $environment->baseUrl(),
            'timeout' => config('services.hostaway.timeout'), // Set the timeout to 10 seconds
        ]);
    }

    /** @inheritDoc */
    public function send(HostAwayRequest $request): ResponseInterface
    {
        return $this->client->send($request);
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
