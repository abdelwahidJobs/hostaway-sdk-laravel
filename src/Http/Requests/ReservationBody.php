<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

use Backend\HostawaySdkLaravel\Dto\Reservation;
use Backend\HostawaySdkLaravel\Exceptions\JsonEncodingException;

class ReservationBody
{

    public Reservation $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
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

    public function toArray(): array
    {
        return [
            'channelId' => $this->reservation->channelId,
            'listingMapId' => $this->reservation->listingMapId,
            'isManuallyChecked' => $this->reservation->isManuallyChecked,
//            'channelName'=> $this->reservation->channelName,
            'guestName' => $this->reservation->guestName,
            'guestFirstName' => $this->reservation->guestFirstName,
            'guestLastName' => $this->reservation->guestLastName,
            'guestZipCode' => $this->reservation->guestZipCode,
            'guestAddress' => $this->reservation->guestAddress,
            'guestCity' => $this->reservation->guestCity,
            'guestCountry' => $this->reservation->guestCountry,
            'guestEmail' => $this->reservation->guestEmail,
            'guestPicture' => $this->reservation->guestPicture,
            'guestRecommendations' => $this->reservation->guestRecommendations,
            'guestTrips' => $this->reservation->guestTrips,
            'guestWork' => $this->reservation->guestWork,
            'isGuestIdentityVerified' => $this->reservation->isGuestIdentityVerified,
            'isGuestVerifiedByEmail' => $this->reservation->isGuestVerifiedByEmail,
            'isGuestVerifiedByWorkEmail' => $this->reservation->isGuestVerifiedByWorkEmail,
            'isGuestVerifiedByFacebook' => $this->reservation->isGuestVerifiedByFacebook,
            'isGuestVerifiedByGovernmentId' => $this->reservation->isGuestVerifiedByGovernmentId,
            'isGuestVerifiedByPhone' => $this->reservation->isGuestVerifiedByPhone,
            'isGuestVerifiedByReviews' => $this->reservation->isGuestVerifiedByReviews,
            'numberOfGuests' => $this->reservation->numberOfGuests,
            'adults' => $this->reservation->adults,
            'children' => $this->reservation->children,
            'infants' => $this->reservation->infants,
            'pets' => $this->reservation->pets,
            'arrivalDate' => $this->reservation->arrivalDate,
            'departureDate' => $this->reservation->departureDate,
            'checkInTime' => $this->reservation->checkInTime,
            'checkOutTime' => $this->reservation->checkOutTime,
            'phone' => $this->reservation->phone,
            'totalPrice' => $this->reservation->totalPrice,
            'taxAmount' => $this->reservation->taxAmount,
            'channelCommissionAmount' => $this->reservation->channelCommissionAmount,
            'cleaningFee' => $this->reservation->cleaningFee,
            'securityDepositFee' => $this->reservation->securityDepositFee,
            'isPaid' => $this->reservation->isPaid,
            'currency' => $this->reservation->currency,
            'hostNote' => $this->reservation->hostNote,
            'guestNote' => $this->reservation->guestNote,
            'guestLocale' => $this->reservation->guestLocale,
            'doorCode' => $this->reservation->doorCode,
            'doorCodeVendor' => $this->reservation->doorCodeVendor,
            'doorCodeInstruction' => $this->reservation->doorCodeInstruction,
            'comment' => $this->reservation->comment,
            'customerUserId' => $this->reservation->customerUserId,
            'customFieldValues' => $this->reservation->customFieldValues,
            'status' => $this->reservation->status,
            'financeField' => $this->reservation->financeField,
        ];

    }
}
