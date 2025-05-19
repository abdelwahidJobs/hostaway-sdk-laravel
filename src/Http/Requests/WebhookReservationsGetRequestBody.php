<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

/**
 * limit    no    int    Maximum number of items in the list.
 * offset    no    int    Number of items to skip from beginning of the list.
 */
class WebhookReservationsGetRequestBody
{
    public array $query;

    public function __construct(array $query)
    {
        $this->query = $query;
    }

    public function addItem(string $key, $value)
    {
        $this->query[$key] = $value;
    }

    public function getQuery(): string
    {
        return http_build_query($this->query);
    }

}
