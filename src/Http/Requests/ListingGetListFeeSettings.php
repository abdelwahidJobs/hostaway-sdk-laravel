<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

class  ListingGetListFeeSettings extends HostAwayRequest
{
    public function __construct(int $listing_id)
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'cache-control' => 'no-cache'
        ];

        $uri = str_replace(':listing_id', urlencode($listing_id), '/v1/listingFeeSettings/:listing_id?provider=wechalet');
        parent::__construct('GET', $uri, $headers);
    }
}
