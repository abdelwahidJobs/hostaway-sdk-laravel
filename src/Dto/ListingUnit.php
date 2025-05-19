<?php

namespace Backend\HostawaySdkLaravel\Dto;

use Spatie\DataTransferObject\FlexibleDataTransferObject;
use Backend\HostawaySdkLaravel\Traits\HasCollection;

class ListingUnit extends FlexibleDataTransferObject
{
    use HasCollection;

    public int $id;
    public string $name;
    public ?string $ground;
    public ?string $unitNumber;
    public ?string $listingMapIdUnit;
}
