<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

use GuzzleHttp\Psr7\Utils;
use Backend\HostawaySdkLaravel\Dto\Listing;

class ListingUpdateRequest extends HostAwayRequest
{
    public function __construct(Listing $listing)
    {

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'cache-control' => 'no-cache'
        ];

        $payload = new ListingBody($listing);
        $body = Utils::streamFor((string)$payload);
        $uri = str_replace(':listing_id', urlencode($listing->id), '/v1/listings/:listing_id?provider=wechalet');
        parent::__construct('PUT', $uri, $headers, $body);
    }
}
