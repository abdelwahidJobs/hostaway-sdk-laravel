<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

use Backend\HostawaySdkLaravel\Dto\Listing;
use Wechalet\HostAway\Exceptions\JsonEncodingException;

class ListingBody
{

    public Listing $listing;

    public function __construct(Listing $listing)
    {
        $this->listing = $listing;
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
            'name' => $this->listing->name,
            'internalListingName' => $this->listing->internalListingName,
            'externalListingName' => $this->listing->externalListingName,
            'address' => $this->listing->address,
            'currencyCode' => $this->listing->currencyCode,
            'bathroomsNumber' => $this->listing->bathroomsNumber,
            'personCapacity' => $this->listing->personCapacity,
            'price' => $this->listing->price,
            'instantBookable' => $this->listing->instantBookable,
            'minNights' => $this->listing->minNights,
            'maxNights' => $this->listing->maxNights,
            'houseRules' => $this->listing->houseRules,
            'keyPickup' => $this->listing->keyPickup,
            'specialInstruction' => $this->listing->specialInstruction,
            'weeklyDiscount' => $this->listing->weeklyDiscount,
            'monthlyDiscount' => $this->listing->monthlyDiscount,
            'refundableDamageDeposit' => $this->listing->refundableDamageDeposit,
            'guestsIncluded' => $this->listing->guestsIncluded,
            'cleaningFee' => $this->listing->cleaningFee,
            'priceForExtraPerson' => $this->listing->priceForExtraPerson,
            'wifiUsername' => $this->listing->wifiUsername,
            'wifiPassword' => $this->listing->wifiPassword,
            'propertyLicenseNumber' => $this->listing->propertyLicenseNumber,
            'propertyLicenseExpirationDate' => $this->listing->propertyLicenseExpirationDate,
        ];

    }
}
