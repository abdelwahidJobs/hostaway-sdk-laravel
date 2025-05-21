<?php

namespace Tests\Http\Requests;

use Backend\HostawaySdkLaravel\Http\Requests\CalendarGetRequest;
use Backend\HostawaySdkLaravel\Http\Requests\CalendarGetRequestBody;
use Orchestra\Testbench\TestCase;

class CalendarGetRequestTest extends TestCase
{

    /** @test */
    public function it_has_correct_uri()
    {

        $request_body = new CalendarGetRequestBody([]);
        $request = new CalendarGetRequest(95503, $request_body);
        $this->assertEquals('/v1/listings/95503/calendar', $request->getUri());
    }

    /** @test */
    public function it_has_correct_method()
    {
        $request_body = new CalendarGetRequestBody([]);
        $request = new CalendarGetRequest(95503, $request_body);

        $this->assertEquals('GET', $request->getMethod());
    }

    /** @test */
    public function it_has_correct_headers()
    {
        $request_body = new CalendarGetRequestBody([]);
        $request = new CalendarGetRequest(95503, $request_body);

        $this->assertEquals('application/json', $request->getHeaderLine('Content-Type'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals('no-cache', $request->getHeaderLine('cache-control'));
    }

    /**
     * @test
     */
    /** @test */
    public function it_can_get_calendar_without_reservation()
    {
        // Arrange: Expected mock response
        $mockedResponse = [
            'result' => [
                [
                    'date' => '2022-03-19',
                    'isAvailable' => 1,
                    'isProcessed' => 1,
                    'status' => 'available',
                    'price' => 100,
                    'minimumStay' => 1,
                    'maximumStay' => 365,
                    'closedOnArrival' => null,
                    'closedOnDeparture' => null,
                    'note' => null,
                    'countAvailableUnits' => 1,
                    'availableUnitsToSell' => 1,
                    'countPendingUnits' => 0,
                    'countBlockingReservations' => 0,
                    'countBlockedUnits' => 0,
                    'countReservedUnits' => 0,
                    'desiredUnitsToSell' => null,
                    'reservations' => [],
                    'id' => 56907370,
                ],
                [
                    'date' => '2022-03-20',
                    'isAvailable' => 1,
                    'isProcessed' => 1,
                    'status' => 'available',
                    'price' => 100,
                    'minimumStay' => 1,
                    'maximumStay' => 365,
                    'closedOnArrival' => null,
                    'closedOnDeparture' => null,
                    'note' => null,
                    'countAvailableUnits' => 1,
                    'availableUnitsToSell' => 1,
                    'countPendingUnits' => 0,
                    'countBlockingReservations' => 0,
                    'countBlockedUnits' => 0,
                    'countReservedUnits' => 0,
                    'desiredUnitsToSell' => null,
                    'reservations' => [],
                    'id' => 56907371,
                ]
            ]
        ];

        // Set up Guzzle mock
        $mockHandler = new \GuzzleHttp\Handler\MockHandler([
            new \GuzzleHttp\Psr7\Response(200, [], json_encode($mockedResponse))
        ]);
        $handlerStack = \GuzzleHttp\HandlerStack::create($mockHandler);
        $mockedClient = new \GuzzleHttp\Client(['handler' => $handlerStack]);

        // Prepare your real HostAwayHttpClient but inject mocked Guzzle
        $environment = $this->createMock(\Backend\HostawaySdkLaravel\Http\Environment\Environment::class);
        $environment->method('baseUrl')->willReturn('https://mock.hostaway.test');

        $client = new \Backend\HostawaySdkLaravel\Http\Client\HostAwayHttpClient($environment);
        $client->setClient($mockedClient); // Inject the mocked client

        // Create request
        $request_body = new \Backend\HostawaySdkLaravel\Http\Requests\CalendarGetRequestBody([
            'startDate' => '2022-03-19',
            'endDate' => '2022-03-20',
            'includeResources' => 0,
        ]);
        $request = new \Backend\HostawaySdkLaravel\Http\Requests\CalendarGetRequest(95503, $request_body);
        $requestWithToken = $request->withToken('mocked-access-token');

        // Act
        $response = $client->send($requestWithToken);
        $results = \GuzzleHttp\Utils::jsonDecode((string)$response->getBody(), true);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertSame($mockedResponse['result'], $results['result']);
    }


    /** @test */
    public function it_can_get_calendar_with_reservation()
    {
        // Arrange: Mocked calendar API response with reservation flag
        $mockedResponse = [
            'result' => [
                [
                    'date' => '2022-03-19',
                    'isAvailable' => 1,
                    'isProcessed' => 1,
                    'status' => 'available',
                    'price' => 100,
                    'minimumStay' => 1,
                    'maximumStay' => 365,
                    'closedOnArrival' => null,
                    'closedOnDeparture' => null,
                    'note' => null,
                    'countAvailableUnits' => 1,
                    'availableUnitsToSell' => 1,
                    'countPendingUnits' => 0,
                    'countBlockingReservations' => 0,
                    'countBlockedUnits' => 0,
                    'countReservedUnits' => 0,
                    'desiredUnitsToSell' => null,
                    'reservations' => [],
                    'id' => 56907370
                ],
                [
                    'date' => '2022-03-20',
                    'isAvailable' => 1,
                    'isProcessed' => 1,
                    'status' => 'available',
                    'price' => 100,
                    'minimumStay' => 1,
                    'maximumStay' => 365,
                    'closedOnArrival' => null,
                    'closedOnDeparture' => null,
                    'note' => null,
                    'countAvailableUnits' => 1,
                    'availableUnitsToSell' => 1,
                    'countPendingUnits' => 0,
                    'countBlockingReservations' => 0,
                    'countBlockedUnits' => 0,
                    'countReservedUnits' => 0,
                    'desiredUnitsToSell' => null,
                    'reservations' => [],
                    'id' => 56907371
                ]
            ]
        ];

        // Setup: Guzzle mock handler and client
        $mockHandler = new \GuzzleHttp\Handler\MockHandler([
            new \GuzzleHttp\Psr7\Response(200, [], json_encode($mockedResponse))
        ]);
        $handlerStack = \GuzzleHttp\HandlerStack::create($mockHandler);
        $mockedClient = new \GuzzleHttp\Client(['handler' => $handlerStack]);

        // Setup: HostAwayHttpClient with injected mock client
        $environment = $this->createMock(\Backend\HostawaySdkLaravel\Http\Environment\Environment::class);
        $environment->method('baseUrl')->willReturn('https://mock.hostaway.test');

        $client = new \Backend\HostawaySdkLaravel\Http\Client\HostAwayHttpClient($environment);
        $client->setClient($mockedClient);

        // Request: includeResources = 1
        $request_body = new \Backend\HostawaySdkLaravel\Http\Requests\CalendarGetRequestBody([
            'startDate' => '2022-03-19',
            'endDate' => '2022-03-20',
            'includeResources' => 1,
        ]);
        $request = new \Backend\HostawaySdkLaravel\Http\Requests\CalendarGetRequest(95503, $request_body);
        $requestWithToken = $request->withToken('mocked-access-token');

        // Act
        $response = $client->send($requestWithToken);
        $results = \GuzzleHttp\Utils::jsonDecode((string)$response->getBody(), true);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertSame($mockedResponse['result'], $results['result']);
    }

}