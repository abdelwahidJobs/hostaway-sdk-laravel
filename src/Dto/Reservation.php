<?php

namespace Backend\HostawaySdkLaravel\Dto;

use Spatie\DataTransferObject\FlexibleDataTransferObject;

class Reservation extends FlexibleDataTransferObject
{
    use HasCollection;

    public ?int $id;
    public int $listingMapId;
    public int $channelId;
    public ?string $source;
    public ?string $channelName;
    public ?string $reservationId;
    public ?string $hostawayReservationId;
    public ?string $channelReservationId;
    public ?string $externalPropertyId;
    public ?string $externalRatePlanId;
    public ?string $externalUnitId;
    public ?int $assigneeUserId;
    public ?string $manualIcalId;
    public ?string $manualIcalName;
    public ?int $isProcessed;
    public ?int $isManuallyChecked;
    public ?int $isInstantBooked;
    public ?int $hasPullError;
    public $reservationDate;
    public $pendingExpireDate;
    public ?string $guestName;
    public ?string $guestFirstName;
    public ?string $guestLastName;
    public ?string $guestExternalAccountId;
    public ?string $guestZipCode;
    public ?string $guestAddress;
    public ?string $guestCity;
    public ?string $guestCountry;
    public ?string $guestEmail;
    public ?string $guestPicture;
    public ?int $guestRecommendations;
    public ?int $guestTrips;
    public ?string $guestWork;
    public ?int $isGuestIdentityVerified;
    public ?int $isGuestVerifiedByEmail;
    public ?int $isGuestVerifiedByWorkEmail;
    public ?int $isGuestVerifiedByFacebook;
    public ?int $isGuestVerifiedByGovernmentId;
    public ?int $isGuestVerifiedByPhone;
    public ?int $isGuestVerifiedByReviews;
    public ?int $numberOfGuests;
    public ?int $adults;
    public ?int $children;
    public ?int $infants;
    public ?int $pets;
    public $arrivalDate;
    public $departureDate;
    public ?int $isDatesUnspecified;
    public $previousArrivalDate;
    public $previousDepartureDate;
    public ?int $checkInTime;
    public ?int $checkOutTime;
    public ?int $nights;
    public ?string $phone;
    public $totalPrice;
    public $taxAmount;
    public $channelCommissionAmount;
    public $hostawayCommissionAmount;
    public $cleaningFee;
    public $securityDepositFee;
    public ?int $isPaid;
    public ?string $paymentMethod;
    public ?string $stripeGuestId;
    public ?string $currency;
    public ?string $status;
    public $cancellationDate;
    public ?string $cancelledBy;
    public ?string $hostNote;
    public ?string $guestNote;
    public ?string $guestLocale;
    public ?string $doorCode;
    public ?string $doorCodeVendor;
    public ?string $doorCodeInstruction;
    public ?string $comment;
    public ?string $confirmationCode;
    public $airbnbExpectedPayoutAmount;
    public $airbnbListingBasePrice;
    public $airbnbListingCancellationHostFee;
    public $airbnbListingCancellationPayout;
    public $airbnbListingCleaningFee;
    public $airbnbListingHostFee;
    public $airbnbListingSecurityPrice;
    public $airbnbOccupancyTaxAmountPaidToHost;
    public $airbnbTotalPaidAmount;
    public $airbnbTransientOccupancyTaxPaidAmount;
    public ?string $airbnbCancellationPolicy;
    public ?int $isStarred;
    public ?int $isArchived;
    public ?int $isPinned;
    public ?string $guestAuthHash;
    public ?string $guestPortalUrl;
    public $latestActivityOn;
    public ?string $customerUserId;
    public ?array $customFieldValues;
    public ?array $reservationFees;
    public ?array $reservationUnit;
    public ?array $financeField;

    public static function fromCollection(array $listingUnits): array
    {
        return array_map(
            fn(array $data) => new self($data),
            $listingUnits
        );
    }


      /**
     * Convert the model to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Convert the model instance to JSON.
     *
     * @param int $options
     *
     * @return string
     *
     */
    public function toJson(int $options = 0): string
    {
        $json = json_encode($this->toArray(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new JsonEncodingException(json_last_error_msg());
        }

        return $json;
    }

}
