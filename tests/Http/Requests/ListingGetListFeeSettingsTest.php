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
use Backend\HostawaySdkLaravel\Http\Requests\ListingGetListFeeSettings;

class ListingGetListFeeSettingsTest extends TestCase
{
    /** @test */
    public function it_has_correct_uri()
    {
        $request = new ListingGetListFeeSettings(95503);
        $this->assertEquals('/v1/listingFeeSettings/95503', $request->getUri());
    }

    /** @test */
    public function it_has_correct_method()
    {
        $request = new ListingGetListFeeSettings(95503);
        $this->assertEquals('GET', $request->getMethod());
    }

    /** @test */
    public function it_has_correct_headers()
    {
        $request = new ListingGetListFeeSettings(95503);
        $this->assertEquals('application/json', $request->getHeaderLine('Content-Type'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals('no-cache', $request->getHeaderLine('cache-control'));
    }

    /** @test */
    public function it_can_append_headers()
    {
        $request = new ListingGetListFeeSettings(95503);
        $request = $request->withToken('value');
        $this->assertEquals('Bearer value', $request->getHeaderLine('authorization'));
    }

    /** @test */
    public function it_can_fetch_listing()
    {
        // Prepare fake JSON response for the listing fee settings
        $mockResponseBody = json_encode([
            'result' => [
                [
                    'id' => 6366,
                    'accountId' => 37187,
                    'listingMapId' => 95503,
                    'feeType' => 'parkingFee',
                    'feeTitle' => null,
                    'feeAppliedPer' => 'night',
                    'amount' => 10,
                    'amountType' => 'flat',
                    'isMandatory' => 0,
                    'isQuantitySelectable' => 0,
                    'insertedOn' => '2022-03-21 17:03:56',
                    'updatedOn' => '2022-03-21 17:03:56',
                ],
                [
                    'id' => 6367,
                    'accountId' => 37187,
                    'listingMapId' => 95503,
                    'feeType' => 'towelChangeFee',
                    'feeTitle' => null,
                    'feeAppliedPer' => 'person_per_night',
                    'amount' => 2,
                    'amountType' => 'flat',
                    'isMandatory' => 0,
                    'isQuantitySelectable' => 0,
                    'insertedOn' => '2022-03-21 17:04:34',
                    'updatedOn' => '2022-03-21 17:04:34',
                ]
            ]
        ]);

        // Setup mock handler with response
        $mock = new MockHandler([
            new Response(200, [], $mockResponseBody),
        ]);

        // Setup the handler stack and client
        $handlerStack = HandlerStack::create($mock);
        $mockClient = new Client(['handler' => $handlerStack]);

        $access_token = 'access-token';
        $request = new ListingGetListFeeSettings(95503);

        // Send request using the mocked client
        $response = $mockClient->send($request->withToken($access_token));

        // Assert status code
        $this->assertEquals(200, $response->getStatusCode());

        // Decode JSON response
        $results = Utils::jsonDecode((string)$response->getBody(), true);

        // Assert the result matches expected structure
        $this->assertEquals([
            [
                'id' => 6366,
                'accountId' => 37187,
                'listingMapId' => 95503,
                'feeType' => 'parkingFee',
                'feeTitle' => null,
                'feeAppliedPer' => 'night',
                'amount' => 10,
                'amountType' => 'flat',
                'isMandatory' => 0,
                'isQuantitySelectable' => 0,
                'insertedOn' => '2022-03-21 17:03:56',
                'updatedOn' => '2022-03-21 17:03:56',
            ],
            [
                'id' => 6367,
                'accountId' => 37187,
                'listingMapId' => 95503,
                'feeType' => 'towelChangeFee',
                'feeTitle' => null,
                'feeAppliedPer' => 'person_per_night',
                'amount' => 2,
                'amountType' => 'flat',
                'isMandatory' => 0,
                'isQuantitySelectable' => 0,
                'insertedOn' => '2022-03-21 17:04:34',
                'updatedOn' => '2022-03-21 17:04:34',
            ]
        ], $results['result']);
    }

}