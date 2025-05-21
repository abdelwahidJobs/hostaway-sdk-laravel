<?php

namespace Tests\Http\Requests;

use Backend\HostawaySdkLaravel\Http\Requests\ListingsGetRequest;
use GuzzleHttp\Utils;
use Orchestra\Testbench\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class ListingsGetRequestTest extends TestCase
{

    /** @test */
    public function it_has_correct_uri()
    {
        $request = new ListingsGetRequest();
        $this->assertEquals('/v1/listings', $request->getUri());
    }

    /** @test */
    public function it_has_correct_method()
    {
        $request = new ListingsGetRequest();
        $this->assertEquals('GET', $request->getMethod());
    }

    /** @test */
    public function it_has_correct_headers()
    {
        $request = new ListingsGetRequest();
        $this->assertEquals('application/json', $request->getHeaderLine('Content-Type'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals('no-cache', $request->getHeaderLine('cache-control'));
    }

    /** @test */
    public function it_can_append_headers()
    {
        $request = new ListingsGetRequest();
        $request = $request->withToken('value');
        $this->assertEquals('Bearer value', $request->getHeaderLine('authorization'));
    }

    /** @test */
    public function it_can_fetch_all_listings()
    {
        // Prepare mock JSON response for multiple listings
        $mockResponseBody = json_encode([
            'result' => [
                ["id" => 95503, "name" => "test"],
                ["id" => 140682, "name" => "WeChalet INC"],
                ["id" => 140752, "name" => "Test listing 1"],
                ["id" => 188391, "name" => "Baker Pace"],
                ["id" => 188393, "name" => "Hayden Zimmerman"],
                ["id" => 189077, "name" => "Pamela Daniel"],
                ["id" => 190504, "name" => "wechalet inc 2"],
                ["id" => 196540, "name" => "La mini de St-Jean test"],
                ["id" => 201858, "name" => "`wahid listing"],
                ["id" => 203776, "name" => "Judith Holden"],
                ["id" => 216180, "name" => "Cheryl Roman"],
                ["id" => 221130, "name" => "McKenzie Buckner"],
            ],
        ]);

        // Setup mock handler with the mock response
        $mock = new MockHandler([
            new Response(200, [], $mockResponseBody),
        ]);

        // Create handler stack and client with mock handler
        $handlerStack = HandlerStack::create($mock);
        $mockClient = new Client(['handler' => $handlerStack]);

        $request = new ListingsGetRequest();
        $access_token = 'access-token';

        // Use mocked client to send the request
        $response = $mockClient->send($request->withToken($access_token));

        $this->assertEquals(200, $response->getStatusCode());

        $results = Utils::jsonDecode((string)$response->getBody(), true);

        $data = collect($results['result'])->map(fn($elem) => [
            'id' => $elem['id'],
            'name' => $elem['name'],
        ]);

        $this->assertEquals(
            [
                0 => ["id" => 95503, "name" => "test"],
                1 => ["id" => 140682, "name" => "WeChalet INC"],
                2 => ["id" => 140752, "name" => "Test listing 1"],
                3 => ["id" => 188391, "name" => "Baker Pace"],
                4 => ["id" => 188393, "name" => "Hayden Zimmerman"],
                5 => ["id" => 189077, "name" => "Pamela Daniel"],
                6 => ["id" => 190504, "name" => "wechalet inc 2"],
                7 => ["id" => 196540, "name" => "La mini de St-Jean test"],
                8 => ["id" => 201858, "name" => "`wahid listing"],
                9 => ["id" => 203776, "name" => "Judith Holden"],
                10 => ["id" => 216180, "name" => "Cheryl Roman"],
                11 => ["id" => 221130, "name" => "McKenzie Buckner"],
            ],
            $data->toArray()
        );
    }
}