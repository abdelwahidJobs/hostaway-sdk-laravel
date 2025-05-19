<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

use GuzzleHttp\Psr7\Utils;
use Backend\HostawaySdkLaravel\Dto\Reservation;

class ReservationUpdateRequest extends HostAwayRequest
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
        $uri = str_replace(':reservation_id', urlencode($reservation->id), '/v1/reservations/:reservation_id?provider=wechalet');
        parent::__construct('PUT', $uri, $headers, $body);
    }
}
