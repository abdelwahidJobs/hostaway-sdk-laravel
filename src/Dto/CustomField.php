<?php

namespace Backend\HostawaySdkLaravel\Dto;

use Spatie\DataTransferObject\FlexibleDataTransferObject;

class CustomField extends FlexibleDataTransferObject
{
    public $id;
    public $accountId;
    public $customFieldValue;
    public $name;
    public $varName;
    public $possibleValues;
    public $type;
    public $objectType;
    public $isPublic;
    public $sortOrder;
}
