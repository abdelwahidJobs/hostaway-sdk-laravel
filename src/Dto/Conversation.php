<?php

namespace Backend\HostawaySdkLaravel\Dto;

use Spatie\DataTransferObject\FlexibleDataTransferObject;

class Conversation extends FlexibleDataTransferObject
{
    use HasCollection;

    public int $id;
    public int $listingMapId;
    public int $reservationId;
    public string $type;
    public ?string $recipientEmail;
    public ?string $recipientPicture;
    public string $hostEmail;
    public string $guestEmail;
    public ?int $hasUnreadMessages;
    public ?string $messageSentOn;
    public ?string $messageReceivedOn;
    public ?array $conversationMessages;
    public ?Reservation $Reservation;
}
