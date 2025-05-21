<?php

namespace Tests\Http\Requests;

use Backend\HostawaySdkLaravel\Dto\Reservation;
use Backend\HostawaySdkLaravel\Http\Requests\ReservationCreateRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Utils;
use Orchestra\Testbench\TestCase;

class ReservationCreateRequestTest extends TestCase
{


    /** @test */
    public function it_has_correct_uri()
    {
        $request = new ReservationCreateRequest($this->reservation());
        $this->assertEquals('/v1/reservations', $request->getUri());
    }

    private function reservation(): Reservation
    {

        return new Reservation([
            'channelReservationId' => '66a12eeb-d60e-4e81-a6b5-9bda2e9b6dc3',
            'externalPropertyId' => '22cee81a-db3e-4b45-ba86-0f9c5095c014',
            'channelId' => 2000,
            'listingMapId' => 95503,
            'isManuallyChecked' => 0,
            'channelName' => 'airbnb',
            'guestName' => 'Andrew Peterson',
            'guestFirstName' => 'Andrew',
            'guestLastName' => 'Peterson',
            'guestZipCode' => null,
            'guestAddress' => null,
            'guestCity' => null,
            'guestCountry' => null,
            'guestEmail' => 'abdoo.max@gmail.com',
            'guestPicture' => 'https=>//a0.muscache.com/im/pictures/3c4d82ed-196d-493a-a43b-07fcc70d5ccd.jpg?aki_policy=profile_small',
            'guestRecommendations' => null,
            'guestTrips' => 10,
            'guestWork' => null,
            'isGuestIdentityVerified' => null,
            'isGuestVerifiedByEmail' => 1,
            'isGuestVerifiedByWorkEmail' => null,
            'isGuestVerifiedByFacebook' => 1,
            'isGuestVerifiedByGovernmentId' => null,
            'isGuestVerifiedByPhone' => 1,
            'isGuestVerifiedByReviews' => null,
            'numberOfGuests' => 1,
            'adults' => 2,
            'children' => 1,
            'infants' => 2,
            'pets' => null,
            'arrivalDate' => '2022-07-07',
            'departureDate' => '2022-07-12',
            'checkInTime' => null,
            'checkOutTime' => null,
            'phone' => null,
            'totalPrice' => 267,
            'taxAmount' => null,
            'channelCommissionAmount' => null,
            'cleaningFee' => 20,
            'securityDepositFee' => 40,
            'isPaid' => 1,
            'currency' => 'CAD',
            'hostNote' => null,
            'guestNote' => null,
            'guestLocale' => null,
            'doorCode' => '12345',
            'doorCodeVendor' => 'test',
            'doorCodeInstruction' => 'test',
            'comment' => null,
            'customerUserId' => null,
            'customFieldValues' => []
        ]);

    }

    /** @test */
    public function it_has_correct_method()
    {
        $request = new ReservationCreateRequest($this->reservation());

        $this->assertEquals('POST', $request->getMethod());
    }

    /** @test */
    public function it_has_correct_headers()
    {
        $request = new ReservationCreateRequest($this->reservation());

        $this->assertEquals('application/json', $request->getHeaderLine('Content-Type'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals('no-cache', $request->getHeaderLine('cache-control'));
    }

    /** @test */
    public function it_can_create_reservation()
    {
        $reservation = $this->reservation(); // Your reservation data object
        $access_token = 'access-toke';

        // Mock JSON response matching expected API response
        $mockResponseBody = json_encode([
            'result' => [
                'listingMapId' => $reservation->listingMapId,
                // you can add more fields here if needed
            ],
        ]);

        // Setup the mock handler with a 200 response
        $mock = new MockHandler([
            new Response(200, [], $mockResponseBody),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $mockClient = new Client(['handler' => $handlerStack]);

        $request = new ReservationCreateRequest($reservation);

        // Use the mocked client to send the request
        $response = $mockClient->send($request->withToken($access_token));

        $this->assertEquals(200, $response->getStatusCode());

        $results = Utils::jsonDecode((string)$response->getBody(), true);

        $this->assertSame($reservation->listingMapId, $results['result']['listingMapId']);
    }
}