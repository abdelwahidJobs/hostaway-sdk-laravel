<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

use GuzzleHttp\Psr7\Utils;

class WebhookReservationUpdateRequest extends HostAwayRequest
{
    public function __construct(int $webhook_id, WechaletWebhook $wechaletWebhook)
    {

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'cache-control' => 'no-cache'
        ];
        $body = Utils::streamFor((string)$wechaletWebhook);
        $uri = str_replace(':webhook_id', urlencode($webhook_id), '/v1/webhooks/reservations/:webhook_id?provider=wechalet');
        parent::__construct('PUT', $uri, $headers, $body);
    }
}
