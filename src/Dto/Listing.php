<?php

namespace Backend\HostawaySdkLaravel\Dto;

use Spatie\DataTransferObject\FlexibleDataTransferObject;
use Backend\HostawaySdkLaravel\Traits\HasCollection;

class Listing extends FlexibleDataTransferObject
{
    use HasCollection;

    public ?int $id;
    public ?int $propertyTypeId;
    public ?string $name;
    public ?string $externalListingName;
    public ?string $internalListingName;
    public ?string $description;
    public ?string $thumbnailUrl;
    public ?string $houseRules;
    public ?string $keyPickup;
    public ?string $specialInstruction;
    public ?string $doorSecurityCode;
    public ?string $country;
    public ?string $countryCode;
    public ?string $state;
    public ?string $city;
    public ?string $street;
    public ?string $address;
    public ?string $publicAddress;
    public ?string $zipcode;
    public $price;
    public $starRating;
    public $weeklyDiscount;
    public $monthlyDiscount;
    public $propertyRentTax;
    public $guestPerPersonPerNightTax;
    public $guestStayTax;
    public $guestNightlyTax;
    public $refundableDamageDeposit;
    public ?int $personCapacity;
    public ?int $maxChildrenAllowed;
    public ?int $maxInfantsAllowed;
    public ?int $maxPetsAllowed;
    public $lat;
    public $lng;
    public $checkInTimeStart;
    public $checkInTimeEnd;
    public $checkOutTime;
    public ?string $cancellationPolicy;
    public $squareMeters;
    public $roomType;
    public $bathroomType;
    public $bedroomsNumber;
    public $bedsNumber;
    public $bedType;
    public $bathroomsNumber;
    public $minNights;
    public $maxNights;
    public $guestsIncluded;
    public $cleaningFee;//bl	no	float
    public $priceForExtraPerson;
    public $instantBookable;//	no	bool
    public $instantBookableLeadTime;
    public $allowSameDayBooking;
    public $sameDayBookingLeadTime;
    public $contactName;
    public $contactSurName;
    public $contactPhone1;
    public $contactPhone2;
    public $contactLanguage;
    public $contactEmail;
    public $contactAddress;
    public $language;
    public ?string $currencyCode;
    public $timeZoneName;
    public $wifiUsername;
    public $wifiPassword;
    public $cleannessStatus;
    public $cleaningInstruction;
    public $cleannessStatusUpdatedOn;
    public $homeawayPropertyName;
    public $homeawayPropertyHeadline;
    public $homeawayPropertyDescription;
    public $bookingcomPropertyName;
    public $bookingcomPropertyDescription;
    public $invoicingContactName;
    public $invoicingContactSurName;
    public $invoicingContactPhone1;
    public $invoicingContactPhone2;
    public $invoicingContactLanguage;
    public $invoicingContactEmail;
    public $invoicingContactAddress;
    public $invoicingContactCity;
    public $invoicingContactZipcode;
    public $invoicingContactCountry;
    public $propertyLicenseNumber;
    public $propertyLicenseType;
    public $propertyLicenseIssueDate;
    public $propertyLicenseExpirationDate;
    public $partnersListingMarkup;
    public $airbnbBookingLeadTime;
    public $airbnbBookingLeadTimeAllowRequestToBook;
    public ?array $listingAmenities;
    public ?array $listingBedTypes;
    public ?array $listingImages;
    public ?array $customFieldValues;
    public $listingFeeSetting;

    public function id()
    {
        return $this->id;
    }
}
