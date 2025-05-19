<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

class WebhookReservationsGetRequest extends HostAwayRequest
{
    public function __construct(WebhookReservationsGetRequestBody $webhookReservationGetRequestBody)
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'cache-control' => 'no-cache'
        ];

        $uri = '/v1/webhooks/reservations?provider=wechalet&' . $webhookReservationGetRequestBody->getQuery();
        parent::__construct('GET', $uri, $headers);
    }
}
