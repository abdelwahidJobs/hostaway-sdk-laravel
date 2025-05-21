<?php

namespace Tests\Http\Requests;

use Backend\HostawaySdkLaravel\Http\Requests\ReservationCancelRequest;
use GuzzleHttp\Utils;
use Orchestra\Testbench\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class ReservationCancelRequestTest extends TestCase
{

    /** @test */
    public function it_has_correct_uri()
    {
        $this->assertEquals('/v1/reservations/14187567/statuses/cancelled', $this->request->getUri());
    }

    /** @test */
    public function it_has_correct_method()
    {
        $this->assertEquals('PUT', $this->request->getMethod());
    }

    /** @test */
    public function it_has_correct_headers()
    {
        $this->assertEquals('application/json', $this->request->getHeaderLine('Content-Type'));
        $this->assertEquals('application/json', $this->request->getHeaderLine('Accept'));
        $this->assertEquals('no-cache', $this->request->getHeaderLine('cache-control'));
    }

    /** @test */
    public function it_can_cancel_reservation()
    {
        // Mock JSON response body
        $mockResponseBody = json_encode([
            'result' => [
                'id' => 14187567,
                'status' => 'cancelled',
            ],
        ]);

        // Setup the mock handler with the response
        $mock = new MockHandler([
            new Response(200, [], $mockResponseBody),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $mockClient = new Client(['handler' => $handlerStack]);

        // Assuming $this->request is your cancellation request object
        $access_token = 'access-token';

        // Send the request with the mocked client
        $response = $mockClient->send($this->request->withToken($access_token));

        $this->assertEquals(200, $response->getStatusCode());

        $results = Utils::jsonDecode((string)$response->getBody(), true);

        $this->assertSame(14187567, $results['result']['id']);
        $this->assertSame('cancelled', $results['result']['status']);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ReservationCancelRequest(14187567, 'guest');
    }
}

