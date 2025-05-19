<?php

namespace Backend\HostawaySdkLaravel\Dto;

use Spatie\DataTransferObject\FlexibleDataTransferObject;
use Backend\HostawaySdkLaravel\Traits\HasCollection;

class ReduceListing extends FlexibleDataTransferObject
{
    use HasCollection;

    public int $id;
    public string $name;
    public string $externalListingName;
    public ?string $internalListingName;
    public ?string $thumbnailUrl;

    public function id()
    {
        return $this->id;
    }
}
