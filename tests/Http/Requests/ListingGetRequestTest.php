<?php

namespace Tests\Http\Requests;

use Backend\HostawaySdkLaravel\Http\Requests\ListingGetRequest;
use GuzzleHttp\Utils;
use Orchestra\Testbench\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;


class ListingGetRequestTest extends TestCase
{

    /** @test */
    public function it_has_correct_uri()
    {
        $request = new ListingGetRequest('51953364');
        $this->assertEquals('/v1/listings/51953364', $request->getUri());
    }

    /** @test */
    public function it_has_correct_method()
    {
        $request = new ListingGetRequest('51953364');
        $this->assertEquals('GET', $request->getMethod());
    }

    /** @test */
    public function it_has_correct_headers()
    {
        $request = new ListingGetRequest('51953364');
        $this->assertEquals('application/json', $request->getHeaderLine('Content-Type'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals('no-cache', $request->getHeaderLine('cache-control'));
    }

    /** @test */
    public function it_can_append_headers()
    {
        $request = new ListingGetRequest('51953364');
        $request = $request->withToken('value');
        $this->assertEquals('Bearer value', $request->getHeaderLine('authorization'));
    }

    /** @test */
    public function it_can_fetch_listing()
    {
        // Prepare fake JSON response for the listing
        $mockResponseBody = json_encode([
            'result' => [
                'id' => 95503,
                // other expected fields can be added here if needed
            ]
        ]);

        // Setup mock handler with the mock response
        $mock = new MockHandler([
            new Response(200, [], $mockResponseBody),
        ]);

        // Create handler stack and client with mock handler
        $handlerStack = HandlerStack::create($mock);
        $mockClient = new Client(['handler' => $handlerStack]);

        $access_token = 'acccess-token';
        $request = new ListingGetRequest(95503);

        // Use the mocked client to send the request
        $response = $mockClient->send($request->withToken($access_token));

        $this->assertEquals(200, $response->getStatusCode());

        $results = Utils::jsonDecode((string)$response->getBody(), true);

        $this->assertEquals(95503, $results['result']['id']);
    }

}