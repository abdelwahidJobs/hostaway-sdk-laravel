<?php

namespace Backend\HostawaySdkLaravel\Dto;

use Spatie\DataTransferObject\FlexibleDataTransferObject;

class FinanceStandardField extends FlexibleDataTransferObject
{
    public $id;
    public $accountId;
    public $listingMapId;
    public $channelId;
    public $reservationId;
    public $damageDeposit;
    public $guestChannelFee;
    public $hostChannelFee;
    public $baseRate;
    public $vat;
    public $salesTax;
    public $cityTax;
    public $otherTaxes;
    public $cleaningFeeValue;
    public $additionalCleaningFee;
    public $parkingFee;
    public $towelChangeFee;
    public $midstayCleaningFee;
    public $roomRequestFee;
    public $reservationChangeFee;
    public $checkinFee;
    public $lateCheckoutFee;
    public $otherFees;
    public $creditCardFee;
    public $kitchenLinenFee;
    public $linenPackageFee;
    public $transferFee;
    public $wristbandFee;
    public $extraBedsFee;
    public $serviceFee;
    public $bedLinenFee;
    public $bookingFee;
    public $petFee;
    public $skiPassFee;
    public $tourismFee;
    public $childrenExtraFee;
    public $resortFee;
    public $resortFeeAirbnb;
    public $communityFeeAirbnb;
    public $managementFeeAirbnb;
    public $linenFeeAirbnb;
    public $weeklyDiscount;
    public $roomTax;
    public $transientOccupancyTax;
    public $lodgingTax;
    public $hotelTax;
    public $guestNightlyTax;
    public $guestStayTax;
    public $guestPerPersonPerNightTax;
    public $propertyRentTax;
    public $priceForExtraPerson;
    public $monthlyDiscount;
    public $cancellationPayout;
    public $cancellationHostFee;
    public $couponDiscount;
    public $shareholderDiscount;
    public $lastMinuteDiscount;
    public $employeeDiscount;
    public $otherSpecialDiscount;
    public $paymentServiceProcessingFees;
    public $bookingComCancellationGuestFee;
    public $bookingcomPaymentProcessingFee;
    public $insuranceFee;
    public $manuallySetFields;
    public $customFeeValuesJson;
    public $insertedOn;
    public $updatedOn;
}
