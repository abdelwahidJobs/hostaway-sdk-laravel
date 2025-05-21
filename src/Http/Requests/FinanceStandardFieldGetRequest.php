<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

class FinanceStandardFieldGetRequest extends HostAwayRequest
{
    public function __construct(int $reservationId)
    {

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'cache-control' => 'no-cache'
        ];
        $uri = str_replace(':reservationId', urlencode($reservationId), '/v1/financeStandardField/reservation/:reservationId');
        parent::__construct('GET', $uri, $headers);
    }
}
