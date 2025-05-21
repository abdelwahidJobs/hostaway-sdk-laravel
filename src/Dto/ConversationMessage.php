<?php

namespace Backend\HostawaySdkLaravel\Dto;

use Backend\HostawaySdkLaravel\Traits\HasCollection;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class ConversationMessage extends FlexibleDataTransferObject
{
    use HasCollection;

    public ?int $id;
    public ?int $accountId;
    public ?int $listingMapId;
    public ?int $reservationId;
    public int $conversationId;
    public ?int $communicationId;
    public ?string $airbnbThreadMessageId;
    public string $body;
    public ?string $status;
    public ?int $isIncoming;
    public ?int $isSeen;
    public ?int $sentUsingHostaway;
    public ?string $hash;
    public ?string $listingTimeZoneName;
    public ?string $communicationEvent;
    public ?int $communicationTimeDelta;
    public ?int $communicationApplyListingTimeZone;
    public ?int $communicationAlwaysTrigger;
    public ?string $date;
    public ?string $insertedOn;
    public ?string $updatedOn;

}
