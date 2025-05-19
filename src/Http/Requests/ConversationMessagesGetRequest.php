<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

class ConversationMessagesGetRequest extends HostAwayRequest
{
    public function __construct(int $conversation_id)
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'cache-control' => 'no-cache'
        ];

        $uri = str_replace(':conversation_id', urlencode($conversation_id), '/v1/conversations/:conversation_id/messages?provider=wechalet');
        parent::__construct('GET', $uri, $headers);
    }
}
