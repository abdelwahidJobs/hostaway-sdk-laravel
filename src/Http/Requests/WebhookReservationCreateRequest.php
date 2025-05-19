<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

use GuzzleHttp\Psr7\Utils;

class WebhookReservationCreateRequest extends HostAwayRequest
{
    public function __construct(WechaletWebhook $wechaletWebhook)
    {

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'cache-control' => 'no-cache'
        ];
        $body = Utils::streamFor((string)$wechaletWebhook);
        parent::__construct('POST', '/v1/webhooks/reservations?provider=wechalet', $headers, $body);
    }
}
