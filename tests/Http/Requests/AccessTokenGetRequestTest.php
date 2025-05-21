<?php

namespace Tests\Http\Requests;

use Backend\HostawaySdkLaravel\Http\Client\HostAwayHttpClient;
use Backend\HostawaySdkLaravel\Http\Environment\Environment;
use Backend\HostawaySdkLaravel\Http\Requests\AccessTokenGetRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Utils;
use Orchestra\Testbench\TestCase;

class AccessTokenGetRequestTest extends TestCase
{
    /** @test */
    public function it_has_correct_uri()
    {
        $request = new AccessTokenGetRequest('12', '123');
        $this->assertEquals('/v1/accessTokens', $request->getUri());
    }

    /** @test */
    public function it_has_correct_method()
    {
        $request = new AccessTokenGetRequest('51953364', '51953364');
        $this->assertEquals('POST', $request->getMethod());
    }

    /** @test */
    public function it_has_correct_headers()
    {
        $request = new AccessTokenGetRequest('51953364', '51953364');
        $this->assertEquals('application/x-www-form-urlencoded', $request->getHeaderLine('Content-Type'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals('no-cache', $request->getHeaderLine('cache-control'));
    }

    /** @test */
    public function it_returns_body()
    {
        $request = new AccessTokenGetRequest('51953364', '51953364');
        $this->assertSame(
            'grant_type=client_credentials&client_id=51953364&client_secret=51953364&scope=general',
            $request->buildBody('51953364', '51953364')
        );
    }


    /** @test */
    public function it_can_get_access_token()
    {
        // Mock the API response
        $mockedResponse = [
            "token_type" => "Bearer",
            "expires_in" => 63158400,
            "access_token" => "mocked_access_token_value"
        ];

        // Create a Guzzle mock handler
        $mockHandler = new MockHandler([
            new Response(200, [], json_encode($mockedResponse))
        ]);

        $handlerStack = HandlerStack::create($mockHandler);
        $mockedClient = new Client(['handler' => $handlerStack]);

        // Prepare HostAwayHttpClient with the mocked Guzzle client
        $environment = $this->createMock(Environment::class);
        $environment->method('baseUrl')->willReturn('https://api.mocked-hostaway.com');

        $client = new HostAwayHttpClient($environment);
        $client->setClient($mockedClient);

        // Send the request
        $request = new AccessTokenGetRequest('mock_id', 'mock_secret');
        $response = $client->send($request);

        // Assertions
        $this->assertEquals(200, $response->getStatusCode());

        $decoded = Utils::jsonDecode((string)$response->getBody(), true);
        $this->assertEquals($mockedResponse, $decoded);
    }

}