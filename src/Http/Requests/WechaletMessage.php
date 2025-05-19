<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

use Backend\HostawaySdkLaravel\Dto\ConversationMessage;
use Wechalet\HostAway\Exceptions\JsonEncodingException;

class WechaletMessage
{

    public ConversationMessage $conversationMessage;

    public function __construct(ConversationMessage $conversationMessage)
    {
        $this->conversationMessage = $conversationMessage;
    }

    /**
     * Convert the model to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Convert the model instance to JSON.
     *
     * @param int $options
     *
     * @return string
     *
     */
    public function toJson(int $options = 0): string
    {
        $json = json_encode($this->toArray(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new JsonEncodingException(json_last_error_msg());
        }

        return $json;
    }

    public function toArray(): array
    {
        return [
            'conversationId' => $this->conversationMessage->conversationId,
            'body' => $this->conversationMessage->body,
            'status' => $this->conversationMessage->status,
            'isIncoming' => $this->conversationMessage->isIncoming,
            'isSeen' =>  $this->conversationMessage->isSeen,
            'sentUsingHostaway' =>  $this->conversationMessage->sentUsingHostaway,
            'insertedOn' =>  $this->conversationMessage->insertedOn,
            'updatedOn' =>  $this->conversationMessage->updatedOn,

        ];

    }
}
