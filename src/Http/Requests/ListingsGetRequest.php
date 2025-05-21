<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

class ListingsGetRequest extends HostAwayRequest
{
    public function __construct($params = null)
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'cache-control' => 'no-cache'
        ];


        $query = '';

        if (is_array($params)) {

            $queryParams = [];
            if (isset($params['offset'])) {
                $queryParams[] = 'offset=' . $params['offset'];
            }
            if (isset($params['limit'])) {
                $queryParams[] = 'limit=' . $params['limit'];
            }
            $query = '&' . implode('&', $queryParams);
        }

        parent::__construct('GET', '/v1/listings' . $query, $headers);

    }
}
