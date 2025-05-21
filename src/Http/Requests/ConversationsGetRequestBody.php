<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

/**
 * limit    no    int    Maximum number of items in the list.
 * offset    no    int    Number of items to skip from beginning of the list.
 * reservationId    no    int    reservation id
 * includeResources    no    int    if includeResources flag is 1 then response objects are supplied with supplementary resources, default is 1.
 */
class ConversationsGetRequestBody
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

