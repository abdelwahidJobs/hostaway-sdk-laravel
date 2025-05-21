<?php

namespace Tests\Http\Requests;


use Backend\HostawaySdkLaravel\Http\Requests\ConversationsGetRequest;
use Backend\HostawaySdkLaravel\Http\Requests\ConversationsGetRequestBody;
use Orchestra\Testbench\TestCase;

class ConversationsGetRequestTest extends TestCase
{

    /** @test */
    public function it_has_correct_uri()
    {
        $requestBody = new ConversationsGetRequestBody([
            'limit' => 20,
            'reservationId' => 12618923,
            'includeResources' => 1,
        ]);
        $request = new ConversationsGetRequest($requestBody);


        $this->assertEquals('/v1/conversations&limit=20&reservationId=12618923&includeResources=1', $request->getUri());
    }

    /** @test */
    public function it_has_correct_method()
    {
        $requestBody = new ConversationsGetRequestBody([
            'limit' => 20,
            'reservationId' => 12618923,
            'includeResources' => 1,
        ]);
        $request = new ConversationsGetRequest($requestBody);
        $this->assertEquals('GET', $request->getMethod());
    }

    /** @test */
    public function it_has_correct_headers()
    {
        $requestBody = new ConversationsGetRequestBody([
            'limit' => 20,
            'reservationId' => 12618923,
            'includeResources' => 1,
        ]);
        $request = new ConversationsGetRequest($requestBody);
        $this->assertEquals('application/x-www-form-urlencoded', $request->getHeaderLine('Content-Type'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals('no-cache', $request->getHeaderLine('cache-control'));
    }
}
