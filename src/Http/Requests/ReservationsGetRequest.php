<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

class ReservationsGetRequest extends HostAwayRequest
{
    public function __construct(ReservationGetRequestBody $reservationRequestBody)
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'cache-control' => 'no-cache'
        ];

        $uri = '/v1/reservations?provider=wechalet&' . $reservationRequestBody->getQuery();
        parent::__construct('GET', $uri, $headers);
    }
}
