<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

class WebhookReservationGetRequest extends HostAwayRequest
{
    public function __construct(int $webhook_id)
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'cache-control' => 'no-cache'
        ];

        $uri = str_replace(':webhook_id', urlencode($webhook_id), '/v1/webhooks/reservations/:webhook_id');
        parent::__construct('GET', $uri, $headers);
    }
}
