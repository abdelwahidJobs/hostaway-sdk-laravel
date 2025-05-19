<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

abstract class HostAwayRequest extends Request implements RequestInterface
{
    public function withToken(string $access_token): self
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->withHeader('authorization', 'Bearer ' . $access_token);
    }
}
