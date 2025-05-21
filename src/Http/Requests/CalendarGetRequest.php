<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

class CalendarGetRequest extends HostAwayRequest
{
    public function __construct(int $listing_id, CalendarGetRequestBody $calendarRequestBody)
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'cache-control' => 'no-cache'
        ];

        $uri = str_replace(':listing_id', urlencode($listing_id), '/v1/listings/:listing_id/calendar');
        $uri = $uri . '?' . $calendarRequestBody->getQuery();
        parent::__construct('GET', $uri, $headers);
    }
}
