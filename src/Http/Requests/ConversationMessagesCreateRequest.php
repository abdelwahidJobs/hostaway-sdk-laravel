<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

use GuzzleHttp\Psr7\Utils;

class ConversationMessagesCreateRequest extends HostAwayRequest
{
    public function __construct(int $conversation_id, WechaletMessage $message)
    {


        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'cache-control' => 'no-cache'
        ];
        $body = Utils::streamFor((string)$message);
        $uri = str_replace(':conversation_id', urlencode($conversation_id), '/v1/conversations/:conversation_id/messages?provider=wechalet');
        parent::__construct('POST', $uri, $headers, $body);
    }
}
