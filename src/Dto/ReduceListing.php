<?php

namespace Backend\HostawaySdkLaravel\Dto;

use Backend\HostawaySdkLaravel\Traits\HasCollection;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

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
