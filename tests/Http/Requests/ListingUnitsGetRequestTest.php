<?php

namespace Tests\Http\Requests;

use Backend\HostawaySdkLaravel\Http\Requests\ListingUnitsGetRequest;
use Orchestra\Testbench\TestCase;

class ListingUnitsGetRequestTest extends TestCase
{

    /** @test */
    public function it_has_correct_uri()
    {
        $request = new ListingUnitsGetRequest(95503);
        $this->assertEquals('/v1/listingUnits/95503', $request->getUri());
    }

    /** @test */
    public function it_has_correct_method()
    {
        $request = new ListingUnitsGetRequest(95503);
        $this->assertEquals('GET', $request->getMethod());
    }

    /** @test */
    public function it_has_correct_headers()
    {
        $request = new ListingUnitsGetRequest(95503);
        $this->assertEquals('application/json', $request->getHeaderLine('Content-Type'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals('no-cache', $request->getHeaderLine('cache-control'));
    }

    /** @test */
    public function it_can_append_headers()
    {
        $request = new ListingUnitsGetRequest(95503);
        $request = $request->withToken('value');
        $this->assertEquals('Bearer value', $request->getHeaderLine('authorization'));
    }


}
