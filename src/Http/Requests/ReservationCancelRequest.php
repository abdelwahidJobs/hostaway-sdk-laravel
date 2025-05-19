<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

use GuzzleHttp\Psr7\Utils;

class ReservationCancelRequest extends HostAwayRequest
{
    public function __construct(int $reservation_id, string $cancelled_by)
    {

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'cache-control' => 'no-cache'
        ];

        $request_body = new ReservationCancelBody($cancelled_by);
        $body = Utils::streamFor((string)$request_body);
        $uri = str_replace(':reservation_id', urlencode($reservation_id), '/v1/reservations/:reservation_id/statuses/cancelled?provider=wechalet');
        parent::__construct('PUT', $uri, $headers, $body);
    }
}
