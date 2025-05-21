<?php

namespace Backend\HostawaySdkLaravel\Dto;

use Backend\HostawaySdkLaravel\Traits\HasCollection;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class FeeSettings extends FlexibleDataTransferObject
{
    use HasCollection;

    public int $id;
    public int $accountId;
    public int $listingMapId;
    public string $feeType;
    public ?string $feeTitle;
    public string $feeAppliedPer;
    public $amount;
    public string $amountType;
    public ?int $isMandatory;
    public int $isQuantitySelectable;
    public string $insertedOn;
    public string $updatedOn;
}
