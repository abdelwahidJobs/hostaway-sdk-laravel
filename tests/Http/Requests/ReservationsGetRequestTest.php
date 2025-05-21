<?php

namespace Tests\Http\Requests;

use Backend\HostawaySdkLaravel\Http\Requests\ReservationGetRequestBody;
use Backend\HostawaySdkLaravel\Http\Requests\ReservationsGetRequest;
use GuzzleHttp\Utils;
use Orchestra\Testbench\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class ReservationsGetRequestTest extends TestCase
{

    /** @test */
    public function it_has_correct_uri()
    {

        $this->assertEquals('/v1/reservations', $this->request->getUri());

        $reservationRequestBody = new ReservationGetRequestBody([
            'limit' => 15,
            'sortOrder' => 'arrivalDateDesc',
            'channelId' => 'airbnb',
        ]);
        $request = new ReservationsGetRequest($reservationRequestBody);
        $this->assertEquals('/v1/reservationslimit=15&sortOrder=arrivalDateDesc&channelId=airbnb', $request->getUri());
    }

    /** @test */
    public function it_has_correct_method()
    {
        $this->assertEquals('GET', $this->request->getMethod());
    }

    /** @test */
    public function it_has_correct_headers()
    {
        $this->assertEquals('application/json', $this->request->getHeaderLine('Content-Type'));
        $this->assertEquals('application/json', $this->request->getHeaderLine('Accept'));
        $this->assertEquals('no-cache', $this->request->getHeaderLine('cache-control'));
    }

    /** @test */
    public function it_can_fetch_all_reservations()
    {
        $access_token = 'access-toke';

        // Mock response JSON data similar to your API
        $mockResponseBody = json_encode([
            'result' => [
                [
                    'id' => 12279230,
                    'reservationId' => '37187-95503-2000-6568320753',
                    // add other fields if needed
                ],
                [
                    'id' => 11812168,
                    'reservationId' => '37187-95503-2000-3351497381',
                ],
            ],
        ]);

        // Setup mock handler with 200 status and mock response body
        $mock = new MockHandler([
            new Response(200, [], $mockResponseBody),
        ]);
        $handlerStack = HandlerStack::create($mock);

        // Create a client with the mock handler
        $mockClient = new Client(['handler' => $handlerStack]);

        // Use your pre-existing request instance but with the mock client
        $response = $mockClient->send($this->request->withToken($access_token));

        $this->assertEquals(200, $response->getStatusCode());

        $results = Utils::jsonDecode((string)$response->getBody(), true);

        $data = collect($results['result'])->map(fn($elem) => [
            'id' => $elem['id'],
            'reservationId' => $elem['reservationId'],
        ]);

        $this->assertEquals(
            [
                [
                    'id' => 12279230,
                    'reservationId' => '37187-95503-2000-6568320753',
                ],
                [
                    'id' => 11812168,
                    'reservationId' => '37187-95503-2000-3351497381',
                ],
            ],
            $data->toArray()
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        $reservationRequestBody = new ReservationGetRequestBody([]);
        $this->request = new ReservationsGetRequest($reservationRequestBody);
    }
}