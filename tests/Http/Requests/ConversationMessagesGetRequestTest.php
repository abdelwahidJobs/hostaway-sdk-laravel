<?php

namespace Tests\Http\Requests;

use Backend\HostawaySdkLaravel\Http\Requests\ConversationMessagesGetRequest;
use Orchestra\Testbench\TestCase;

class ConversationMessagesGetRequestTest extends TestCase
{
    /** @test */
    public function it_has_correct_uri()
    {

        $request = new ConversationMessagesGetRequest(4587450);

        $this->assertEquals('/v1/conversations/4587450/messages', $request->getUri());
    }

    /** @test */
    public function it_has_correct_method()
    {
        $request = new ConversationMessagesGetRequest(4587450);

        $this->assertEquals('GET', $request->getMethod());
    }

    /** @test */
    public function it_has_correct_headers()
    {
        $request = new ConversationMessagesGetRequest(4587450);
        $this->assertEquals('application/json', $request->getHeaderLine('Content-Type'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals('no-cache', $request->getHeaderLine('cache-control'));
    }

    /** @test */
    public function it_can_get_conversation_messages()
    {
        // Arrange: Mocked conversation messages response
        $mockedResponse = [
            'result' => [
                [
                    'accountId' => 37187,
                    'listingMapId' => 95503,
                    'reservationId' => 12618923,
                    'conversationId' => 4587450,
                    'communicationId' => null,
                    'airbnbThreadMessageId' => null,
                    'channelId' => null,
                    'channelThreadMessageId' => null,
                    'body' => 'hi Jad account in hostaway this is message send from gmail to replay',
                    'imagesUrls' => null,
                    'bookingcomSubthreadId' => null,
                    'inReplyTo' => null,
                    'bookingcomReplyOptions' => null,
                    'bookingcomSelectedOptions' => null,
                    'isIncoming' => 1,
                    'isSeen' => 0,
                    'sentUsingHostaway' => 0,
                    'hash' => '49338739d4f5916b5a8b16b8f179f628',
                    'listingTimeZoneName' => 'America/New_York',
                    'communicationEvent' => null,
                    'communicationTimeDelta' => null,
                    'communicationTimeDeltaSeconds' => 0,
                    'communicationApplyListingTimeZone' => null,
                    'communicationAlwaysTrigger' => null,
                    'date' => '2022-05-16 10:56:08',
                    'status' => 'sent',
                    'sentChannelDate' => null,
                    'listingName' => null,
                    'insertedOn' => '2022-05-16 10:56:08',
                    'updatedOn' => '2022-05-16 10:56:08',
                    'id' => 29047008,
                ],
                [
                    'accountId' => 37187,
                    'listingMapId' => 95503,
                    'reservationId' => 12618923,
                    'conversationId' => 4587450,
                    'communicationId' => null,
                    'airbnbThreadMessageId' => null,
                    'channelId' => 2000,
                    'channelThreadMessageId' => null,
                    'body' => '<p>this is a message send by the host to the guest&nbsp;</p>',
                    'imagesUrls' => null,
                    'bookingcomSubthreadId' => null,
                    'inReplyTo' => null,
                    'bookingcomReplyOptions' => null,
                    'bookingcomSelectedOptions' => null,
                    'isIncoming' => 0,
                    'isSeen' => 1,
                    'sentUsingHostaway' => 0,
                    'hash' => '394dc53e7feb39cac7a35b814fd5b78f',
                    'listingTimeZoneName' => 'America/New_York',
                    'communicationEvent' => null,
                    'communicationTimeDelta' => null,
                    'communicationTimeDeltaSeconds' => 0,
                    'communicationApplyListingTimeZone' => null,
                    'communicationAlwaysTrigger' => null,
                    'date' => '2022-05-16 10:54:52',
                    'status' => 'sent',
                    'sentChannelDate' => '2022-05-16 10:54:52',
                    'listingName' => null,
                    'insertedOn' => '2022-05-16 10:54:52',
                    'updatedOn' => '2022-05-16 10:54:52',
                    'id' => 29046940,
                ]
            ]
        ];

        // Setup: Guzzle mock handler and client
        $mockHandler = new \GuzzleHttp\Handler\MockHandler([
            new \GuzzleHttp\Psr7\Response(200, [], json_encode($mockedResponse))
        ]);
        $handlerStack = \GuzzleHttp\HandlerStack::create($mockHandler);
        $mockedClient = new \GuzzleHttp\Client(['handler' => $handlerStack]);

        // Setup: Mock environment
        $environment = $this->createMock(\Backend\HostawaySdkLaravel\Http\Environment\Environment::class);
        $environment->method('baseUrl')->willReturn('https://mock.hostaway.test');

        // Setup: HostAway client with mocked Guzzle
        $client = new \Backend\HostawaySdkLaravel\Http\Client\HostAwayHttpClient($environment);
        $client->setClient($mockedClient);

        // Request: Fetch messages
        $request = new \Backend\HostawaySdkLaravel\Http\Requests\ConversationMessagesGetRequest(4587450);
        $requestWithToken = $request->withToken('mocked-access-token');

        // Act
        $response = $client->send($requestWithToken);
        $results = \GuzzleHttp\Utils::jsonDecode((string)$response->getBody(), true);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertSame($mockedResponse['result'], $results['result']);
    }

}