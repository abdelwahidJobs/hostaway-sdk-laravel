<?php

namespace Backend\HostawaySdkLaravel\Exceptions;

use Exception;

class HostAwayException extends Exception
{
    public static function couldNotFetchListings(string $message): self
    {
        return new static('Could not fetch listings from hostaway ' . $message);
    }

    public static function couldNotFetchFeeSettings(string $message): self
    {
        return new static('Could not fetch Fee Settings from hostaway ' . $message);

    }

    public static function authenticationFailed(): self
    {
        return new static('Client authentication failed');
    }

    public static function accessTokenNotSet(): self
    {
        return new static('Your access token is not set. make sure to add `withAccessToken()` before fetching listings');
    }

    public static function clientCredentialsNotSet(): self
    {
        return new static('Your client credentials is not set. make sure to add `withClientCredentials()` before getting access token');
    }


    public static function couldNotFetchWebhookReservation(string $message): self
    {
        return new static('Could not fetch webhook reservation from hostaway ' . $message);
    }

    public static function couldNotCreateWebhookReservation(string $message): self
    {
        return new static('Could not create hostaway webhook reservation ' . $message);
    }

    public static function couldNotUpdateWebhookReservation(string $message): self
    {
        return new static('Could not update hostaway webhook reservation ' . $message);
    }

    public static function couldNotRemoveWebhookReservation(string $message): self
    {
        return new static('Could not remove hostaway webhook reservation ' . $message);
    }

    public static function couldNotFetchReservations(string $message): self
    {
        return new static('Could not fetch reservation from hostaway ' . $message);
    }

    public static function couldNotFetchWebhookReservations(string $message): self
    {
        return new static('Could not fetch reservations from hostaway ' . $message);

    }

    public static function couldNotCreateReservation(string $message): self
    {
        return new static('Could not create reservation ' . $message);
    }

    public static function couldNotFetchConversations(string $message): self
    {
        return new static('Could not fetch conversations from hostaway ' . $message);
    }

    public static function couldNotFetchConversationMessages(string $message): self
    {
        return new static('Could not fetch conversation Messages from hostaway ' . $message);
    }

    public static function couldNotFetchCalendar(string $message): self
    {
        return new static('Could not fetch calendar from hostaway ' . $message);
    }

    public static function couldNotGetFinanceStandardField(string $message): self
    {
        return new static('Could not fetch finance Standard field from hostaway ' . $message);
    }

    public static function couldNotCreateConversationMessage(string $message): self
    {
        return new static('Could not create conversation Message from hostaway ' . $message);
    }

    public static function couldNotUpdateReservation(string $message): self
    {
        return new static('Could not update reservation from hostaway ' . $message);
    }

    public static function couldNotCancelReservation(string $message): self
    {
        return new static('Could not cancel reservation from hostaway ' . $message);
    }

    public static function couldNotCreateWebhookConversation(string $message): self
    {
        return new static('Could not create webhook conversation for hostaway ' . $message);
    }

    public static function couldNotUpdateCalendar(string $message): self
    {
        return new static('Could not update for hostaway listing calendar ' . $message);

    }

    public static function couldNotUpdateListing(string $message): self
    {
        return new static('Could not update for hostaway listing ' . $message);
    }

    public static function couldNotFetchListingsCount(string $message): self
    {

        return new static('Could not fetch listings count from hostaway ' . $message);
    }

    public static function couldNotCreateCustomField(string $message): self
    {
        return new static('Could not create custom field ' . $message);
    }
}
