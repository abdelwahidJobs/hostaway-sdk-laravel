<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

use Backend\HostawaySdkLaravel\Dto\Calendar;
use GuzzleHttp\Psr7\Utils;

class CalendarUpdateRequest extends HostAwayRequest
{
    public function __construct(int $listing_id, Calendar $calendar)
    {

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'cache-control' => 'no-cache'
        ];

        $payload = new CalendarBody($calendar);
        $body = Utils::streamFor((string)$payload);
        $uri = str_replace(':listing_id', urlencode($listing_id), '/v1/listings/:listing_id/calendar');
        parent::__construct('PUT', $uri, $headers, $body);
    }
}
