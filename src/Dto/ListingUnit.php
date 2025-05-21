<?php

namespace Backend\HostawaySdkLaravel\Dto;

use Backend\HostawaySdkLaravel\Traits\HasCollection;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class ListingUnit extends FlexibleDataTransferObject
{
    use HasCollection;

    public int $id;
    public string $name;
    public ?string $ground;
    public ?string $unitNumber;
    public ?string $listingMapIdUnit;
}
