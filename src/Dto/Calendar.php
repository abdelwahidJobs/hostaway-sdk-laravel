<?php

namespace Backend\HostawaySdkLaravel\Dto;

use Backend\HostawaySdkLaravel\Traits\HasCollection;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class Calendar extends FlexibleDataTransferObject
{
    use HasCollection;

    public ?int $id;
    public string $date;
    public $startDate;
    public $endDate;
    public ?int $isAvailable;
    public ?int $isProcessed;
    public ?string $status;
    public $price;
    public ?int $minimumStay;
    public ?int $maximumStay;
    public ?int $closedOnArrival;
    public ?int $closedOnDeparture;
    public ?string $note;
    public ?int $countAvailableUnits;
    public ?int $availableUnitsToSell;
    public ?int $countPendingUnits;
    public ?int $countBlockingReservations;
    public ?int $countBlockedUnits;
    public ?int $desiredUnitsToSell;
    public ?array $reservations;
    public $countReservedUnits;
}
