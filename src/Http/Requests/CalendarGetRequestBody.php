<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

/**
 * startDate    no    date
 * endDate    no    date
 * includeResources    no    int    if includeResources flag is 1 then response objects are supplied with supplementary resources,
 * default is 1.
 */
class CalendarGetRequestBody
{
    public array $query;

    public function __construct(array $query)
    {
        $this->query = $query;
    }

    public function addItem(string $key, $value): void
    {
        $this->query[$key] = $value;
    }

    public function getQuery(): string
    {
        return http_build_query($this->query);
    }

}
