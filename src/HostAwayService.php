<?php

namespace Backend\HostawaySdkLaravel;

use Backend\HostawaySdkLaravel\Dto\AccessToken;
use Backend\HostawaySdkLaravel\Exceptions\HostAwayException;
use Backend\HostawaySdkLaravel\Http\Client\HostAwayHttpClient;
use Backend\HostawaySdkLaravel\Http\Requests\AccessTokenGetRequest;
use GuzzleHttp\Exception\GuzzleException;

class HostAwayService
{

    protected HostAwayHttpClient $client;

    protected string $access_token;
    protected string $client_id;
    protected string $client_secret;
    protected string $api_key;


    public function __construct(HostAwayHttpClient $client)
    {
        $this->client = $client;
    }



    public function withAccessToken(string $access_token): self
    {
        $this->access_token = $access_token;

        return $this;
    }

    public function withApiKey(string $api_key): self
    {
        $this->access_token = $api_key;

        return $this;
    }

    public function withClientCredentials(string $client_id, string $client_secret): self
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;

        return $this;
    }

    /**
     * @throws HostAwayException
     */
    protected function checkClientCredentials(): void
    {

        if (!(isset($this->client_id) && isset($this->client_secret))) {
            throw HostAwayException::clientCredentialsNotSet();
        }
    }

    /**
     * @throws HostAwayException
     */
    public function getAccessToken(): AccessToken
    {
        // check access token before sending request
        $this->checkClientCredentials();

        try {
            // Create hostaway request
            $hostaway_req = (new AccessTokenGetRequest($this->client_id, $this->client_secret));

            $response = $this->client->send($hostaway_req);

            // Parse hostaway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return new AccessToken($result);
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotFetchListings($e->getMessage());
        }
    }
}