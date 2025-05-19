<?php

namespace Backend\HostawaySdkLaravel\Dto;

use Spatie\DataTransferObject\FlexibleDataTransferObject;

class AccessToken extends FlexibleDataTransferObject
{
    public string $token_type;
    public int $expires_in;
    public string $access_token;
}
