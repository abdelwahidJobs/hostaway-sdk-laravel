<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

use Backend\HostawaySdkLaravel\Dto\Webhook;
use Wechalet\HostAway\Exceptions\JsonEncodingException;

class WechaletWebhook
{
    public ?int $listingMapId;
    public ?int $channelId;
    public int $isEnabled;
    public string $url;
    public ?string $login;
    public ?string $password;

    public function __construct(Webhook $webhook)
    {
        $this->listingMapId = $webhook->listingMapId;
        $this->channelId = $webhook->channelId;
        $this->isEnabled = (bool)$webhook->isEnabled;
        $this->url = $webhook->url;
        $this->login = $webhook->login;
        $this->password = $webhook->password;
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
            'listingMapId' => $this->listingMapId,
            'channelId' => $this->channelId,
            'isEnabled' => (bool)$this->isEnabled,
            'url' => $this->url,
            'login' => $this->login,
            'password' => $this->password,
        ];

    }
}
