<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

use Backend\HostawaySdkLaravel\Dto\Listing;
use GuzzleHttp\Psr7\Utils;

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
        $uri = str_replace(':listing_id', urlencode($listing->id), '/v1/listings/:listing_id');
        parent::__construct('PUT', $uri, $headers, $body);
    }
}
