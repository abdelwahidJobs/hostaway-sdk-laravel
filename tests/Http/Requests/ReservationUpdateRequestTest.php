<?php

namespace Tests\Http\Requests;

use Backend\HostawaySdkLaravel\Dto\Reservation;
use Backend\HostawaySdkLaravel\Http\Requests\ReservationUpdateRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Utils;
use Orchestra\Testbench\TestCase;

class ReservationUpdateRequestTest extends TestCase
{

    protected ReservationUpdateRequest $request;

    /** @test */
    public function it_has_correct_uri()
    {
        $this->assertEquals('/v1/reservations/14188731', $this->request->getUri());
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
    public function it_can_update_reservation()
    {
        $access_token = 'access-token';

        // Define the mocked JSON response
        $mockResponseBody = json_encode([
            'result' => [
                'id' => 14188731,
                'arrivalDate' => '2022-12-25',
                'departureDate' => '2022-12-30',
                'status' => 'modified',
                // you can include other fields if needed
            ],
        ]);

        // Set up the mock handler
        $mock = new MockHandler([
            new Response(200, [], $mockResponseBody),
        ]);

        // Create a handler stack
        $handlerStack = HandlerStack::create($mock);

        // Create the mock Guzzle client
        $mockClient = new Client(['handler' => $handlerStack]);

        // Send the request using the mocked client
        $response = $mockClient->send($this->request->withToken($access_token));

        // Run assertions
        $this->assertEquals(200, $response->getStatusCode());

        $results = Utils::jsonDecode((string)$response->getBody(), true);

        $this->assertSame(14188731, $results['result']['id']);
        $this->assertSame('2022-12-25', $results['result']['arrivalDate']);
        $this->assertSame('2022-12-30', $results['result']['departureDate']);
        $this->assertSame('modified', $results['result']['status']);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $reservation = $this->reservation();
        $reservation->id = 14188731;
        $reservation->arrivalDate = '2022-12-25';
        $reservation->departureDate = '2022-12-30';
        $reservation->status = 'new';
        $this->request = new ReservationUpdateRequest($reservation);
    }

    public function reservation(): Reservation
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
            'arrivalDate' => '2024-08-10',
            'departureDate' => '2024-08-14',
            'checkInTime' => null,
            'checkOutTime' => null,
            'phone' => null,
            'totalPrice' => 2950.01,
            'taxAmount' => null,
            'channelCommissionAmount' => null,
            'cleaningFee' => 25.00,
            'securityDepositFee' => null,
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
            'customFieldValues' => [],
            'financeField' => [
                [
                    'id' => null,
                    'listingFeeSettingId' => null,
                    'type' => 'price',
                    'name' => 'baseRate',
                    'title' => 'Nights cost',
                    'alias' => 'Nights cost',
                    'quantity' => 1,
                    'value' => 3175.00,
                    'total' => 3175.00,
                    'isIncludedInTotalPrice' => 1,
                    'isOverriddenByUser' => 0,
                    'isQuantitySelectable' => 0,
                    'isMandatory' => 1,
                    'isDeleted' => 0
                ],
                // cleaning fee
                [
                    'id' => null,
                    'listingFeeSettingId' => null,
                    'type' => 'price',
                    'name' => 'cleaningFee',
                    'title' => 'Cleaning Fee ',
                    'alias' => 'Cleaning Fee',
                    'quantity' => 1,
                    'value' => 25.00,
                    'total' => 25.00,
                    'isIncludedInTotalPrice' => 1,
                    'isOverriddenByUser' => 0,
                    'isQuantitySelectable' => 0,
                    'isMandatory' => 1,
                    'isDeleted' => 0
                ],
                [
                    'id' => null,
                    'listingFeeSettingId' => null,
                    'type' => 'discount',
                    'name' => 'weeklyDiscount',
                    'title' => 'Discount ',
                    'alias' => 'Discount',
                    'quantity' => 1,
                    'value' => -158.75,
                    'total' => -158.75,
                    'isIncludedInTotalPrice' => 1,
                    'isOverriddenByUser' => 0,
                    'isQuantitySelectable' => 0,
                    'isMandatory' => 1,
                    'isDeleted' => 0
                ],
                [
                    'id' => null,
                    'listingFeeSettingId' => null,
                    'type' => 'fee',
                    'name' => 'hostChannelFee',
                    'title' => 'wechalet fee',
                    'alias' => 'wechalet fee',
                    'quantity' => 1,
                    'value' => -91.24,
                    'total' => -91.24,
                    'isIncludedInTotalPrice' => 1,
                    'isOverriddenByUser' => 0,
                    'isQuantitySelectable' => 0,
                    'isMandatory' => 1,
                    'isDeleted' => 0
                ],
            ]
        ]);

    }

}