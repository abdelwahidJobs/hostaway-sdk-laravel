<?php

namespace Tests\Http\Requests;

use GuzzleHttp\Utils;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\TestCase;
use GuzzleHttp\Handler\MockHandler;
use Backend\HostawaySdkLaravel\Http\Environment\Environment;
use Backend\HostawaySdkLaravel\Http\Client\HostAwayHttpClient;
use Backend\HostawaySdkLaravel\Http\Requests\AccessTokenGetRequest;
use Backend\HostawaySdkLaravel\Http\Requests\FinanceStandardFieldGetRequest;

class FinanceStandardFieldGetRequestTest extends TestCase
{
    protected HostAwayHttpClient $client;

    /** @test */
    public function it_has_correct_uri()
    {
        $request = new FinanceStandardFieldGetRequest(51953364);
        $this->assertEquals('/v1/financeStandardField/reservation/51953364', $request->getUri());
    }

    /** @test */
    public function it_has_correct_method()
    {
        $request = new FinanceStandardFieldGetRequest(51953364);
        $this->assertEquals('GET', $request->getMethod());
    }

    /** @test */
    public function it_has_correct_headers()
    {
        $request = new FinanceStandardFieldGetRequest(51953364);
        $this->assertEquals('application/json', $request->getHeaderLine('Content-Type'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals('no-cache', $request->getHeaderLine('cache-control'));
    }

    /** @test */
    public function it_can_append_headers()
    {
        $request = new FinanceStandardFieldGetRequest(51953364);
        $request = $request->withToken('value');
        $this->assertEquals('Bearer value', $request->getHeaderLine('authorization'));
    }

    /** @test */
    public function it_can_fetch_finance_standard_field()
    {
        $mockResponseBody = json_encode([
            'result' => [
                'id' => 1172269,
                'name' => 'Standard Cleaning Fee',
                'type' => 'fee'
            ]
        ]);

        // Prepare a fake HTTP 200 response with mock body
        $mock = new MockHandler([
            new Response(200, [], $mockResponseBody),
        ]);

        // Create a handler stack and client with the mock
        $handlerStack = HandlerStack::create($mock);
        $mockClient = new Client(['handler' => $handlerStack]);

        $access_token = 'mocked_access_token';
        $request = new FinanceStandardFieldGetRequest(11812168);

        // Use the mocked client to send the request
        $response = $mockClient->send($request->withToken($access_token));

        // Assertions
        $this->assertEquals(200, $response->getStatusCode());

        $results = Utils::jsonDecode((string)$response->getBody(), true);

        $this->assertEquals(1172269, $results['result']['id']);
    }
}