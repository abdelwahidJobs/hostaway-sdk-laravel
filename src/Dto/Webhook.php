<?php

namespace Backend\HostawaySdkLaravel\Dto;

use Backend\HostawaySdkLaravel\Traits\HasCollection;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class Webhook extends FlexibleDataTransferObject
{
    use HasCollection;

    public ?int $id;
    public ?int $accountId;
    public ?int $listingMapId;
    public ?int $channelId;
    public int $isEnabled;
    public string $url;
    public ?string $type;
    public ?string $insertedOn;
    public ?string $updatedOn;
    public ?string $listingName;
    public ?string $login;
    public ?string $password;
}
