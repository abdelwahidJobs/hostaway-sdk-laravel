<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

use Backend\HostawaySdkLaravel\Dto\Reservation;
use GuzzleHttp\Psr7\Utils;

class ReservationCreateRequest extends HostAwayRequest
{
    public function __construct(Reservation $reservation)
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'cache-control' => 'no-cache'
        ];

        $payload = new ReservationBody($reservation);
        $body = Utils::streamFor((string)$payload);
        parent::__construct('POST', '/v1/reservations', $headers, $body);
    }
}
