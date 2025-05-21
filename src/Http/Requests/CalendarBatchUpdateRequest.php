<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

use GuzzleHttp\Psr7\Utils;

class CalendarBatchUpdateRequest extends HostAwayRequest
{
    public function __construct(int $listing_id, array $calendars)
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'cache-control' => 'no-cache'
        ];

        $payload = new BatchCalendarBody($calendars);
        $body = Utils::streamFor((string)$payload);
        $uri = str_replace(':listing_id', urlencode($listing_id), '/v1/listings/:listing_id/calendarIntervals');
        parent::__construct('PUT', $uri, $headers, $body);
    }
}
