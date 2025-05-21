<?php

namespace Backend\HostawaySdkLaravel;

use Backend\HostawaySdkLaravel\Dto\AccessToken;
use Backend\HostawaySdkLaravel\Dto\Calendar;
use Backend\HostawaySdkLaravel\Dto\Conversation;
use Backend\HostawaySdkLaravel\Dto\ConversationMessage;
use Backend\HostawaySdkLaravel\Dto\CustomField;
use Backend\HostawaySdkLaravel\Dto\FeeSettings;
use Backend\HostawaySdkLaravel\Dto\FinanceStandardField;
use Backend\HostawaySdkLaravel\Dto\Listing;
use Backend\HostawaySdkLaravel\Dto\ListingUnit;
use Backend\HostawaySdkLaravel\Dto\Reservation;
use Backend\HostawaySdkLaravel\Dto\Webhook;
use Backend\HostawaySdkLaravel\Exceptions\HostAwayException;
use Backend\HostawaySdkLaravel\Http\Client\HostAwayHttpClient;
use Backend\HostawaySdkLaravel\Http\Requests\AccessTokenGetRequest;
use Backend\HostawaySdkLaravel\Http\Requests\CalendarBatchUpdateRequest;
use Backend\HostawaySdkLaravel\Http\Requests\CalendarGetRequest;
use Backend\HostawaySdkLaravel\Http\Requests\CalendarGetRequestBody;
use Backend\HostawaySdkLaravel\Http\Requests\CalendarUpdateRequest;
use Backend\HostawaySdkLaravel\Http\Requests\ConversationMessagesGetRequest;
use Backend\HostawaySdkLaravel\Http\Requests\ConversationsGetRequest;
use Backend\HostawaySdkLaravel\Http\Requests\ConversationsGetRequestBody;
use Backend\HostawaySdkLaravel\Http\Requests\CustomFieldCreateRequest;
use Backend\HostawaySdkLaravel\Http\Requests\FinanceStandardFieldGetRequest;
use Backend\HostawaySdkLaravel\Http\Requests\ListingGetListFeeSettings;
use Backend\HostawaySdkLaravel\Http\Requests\ListingGetRequest;
use Backend\HostawaySdkLaravel\Http\Requests\ListingsGetRequest;
use Backend\HostawaySdkLaravel\Http\Requests\ListingUnitsGetRequest;
use Backend\HostawaySdkLaravel\Http\Requests\ListingUpdateRequest;
use Backend\HostawaySdkLaravel\Http\Requests\ReservationCancelRequest;
use Backend\HostawaySdkLaravel\Http\Requests\ReservationCreateRequest;
use Backend\HostawaySdkLaravel\Http\Requests\ReservationGetRequestBody;
use Backend\HostawaySdkLaravel\Http\Requests\ReservationsGetRequest;
use Backend\HostawaySdkLaravel\Http\Requests\ReservationUpdateRequest;
use Backend\HostawaySdkLaravel\Http\Requests\WebhookReservationGetRequest;
use Backend\HostawaySdkLaravel\Http\Requests\WebhookReservationRemoveRequest;
use Backend\HostawaySdkLaravel\Http\Requests\WebhookReservationsGetRequest;
use Backend\HostawaySdkLaravel\Http\Requests\WebhookReservationsGetRequestBody;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;

class HostAwayService
{

    protected HostAwayHttpClient $client;

    protected string $access_token;
    protected string $client_id;
    protected string $client_secret;


    public function __construct(HostAwayHttpClient $client)
    {
        $this->client = $client;
    }


    public function withAccessToken(string $access_token): self
    {
        $this->access_token = $access_token;

        return $this;
    }

    public function withApiKey(string $api_key): self
    {
        $this->access_token = $api_key;

        return $this;
    }

    public function withClientCredentials(string $client_id, string $client_secret): self
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;

        return $this;
    }

    /**
     * @throws HostAwayException
     */
    protected function checkClientCredentials(): void
    {

        if (!(isset($this->client_id) && isset($this->client_secret))) {
            throw HostAwayException::clientCredentialsNotSet();
        }
    }

    /**
     * @throws HostAwayException
     */
    public function getAccessToken(): AccessToken
    {
        // check access token before sending request
        $this->checkClientCredentials();

        try {
            // Create HostAway request
            $hostaway_req = (new AccessTokenGetRequest($this->client_id, $this->client_secret));

            $response = $this->client->send($hostaway_req);

            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return new AccessToken($result);
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotFetchListings($e->getMessage());
        }
    }


    /**
     * @throws HostAwayException
     */
    public function getListings($params = null): array
    {
        // check access token before sending request
        $this->checkAccessToken();

        try {
            // Create HostAway request
            $hostaway_req = (new ListingsGetRequest($params))->withToken($this->access_token);

            $response = $this->client->send($hostaway_req);

            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return Listing::fromCollection($result['result']);
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotFetchListings($e->getMessage());
        }
    }

    /**
     * @throws HostAwayException
     */
    public function getListingsCount(): int
    {
        // check access token before sending request
        $this->checkAccessToken();

        try {
            // Create HostAway request
            $hostaway_req = (new ListingsGetRequest())->withToken($this->access_token);

            $response = $this->client->send($hostaway_req);

            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return (int)$result['count'];

        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotFetchListingsCount($e->getMessage());
        }
    }


    /**
     * @throws HostAwayException
     */
    public function getAllListings(): array
    {
        // check access token before sending request
        $this->checkAccessToken();

        try {
            // getListingsCreate HostAway request
            $hostaway_req = (new ListingsGetRequest())->withToken($this->access_token);

            $response = $this->client->send($hostaway_req);

            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return Listing::fromCollection($result['result']);
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotFetchListings($e->getMessage());
        }
    }


    /**
     * @throws HostAwayException
     */
    protected function checkAccessToken(): void
    {
        if (!$this->access_token) {
            throw HostAwayException::accessTokenNotSet();
        }
    }

    /**
     * @throws HostAwayException
     */
    public function getListing(int $listing_id): Listing
    {
        // check access token before sending request
        $this->checkAccessToken();
        try {
            // Create HostAway request
            $hostaway_req = (new ListingGetRequest($listing_id))->withToken($this->access_token);

            $response = $this->client->send($hostaway_req);

            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return new Listing($result['result']);
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotFetchListings($e->getMessage());
        }
    }

    /**
     * @throws HostAwayException
     */
    public function getListingListFeeSettings(int $listing_id): array
    {
        // check access token before sending request
        $this->checkAccessToken();
        try {
            // Create HostAway request
            $hostaway_req = (new ListingGetListFeeSettings($listing_id))->withToken($this->access_token);

            $response = $this->client->send($hostaway_req);

            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return FeeSettings::fromCollection($result['result']);
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotFetchFeeSettings($e->getMessage());
        }
    }

    /**
     * @throws HostAwayException
     */
    public function getUnitListing(int $listing_id): array
    {
        // check access token before sending request
        $this->checkAccessToken();
        try {
            // Create HostAway request
            $hostaway_req = (new ListingUnitsGetRequest($listing_id))->withToken($this->access_token);

            $response = $this->client->send($hostaway_req);

            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return ListingUnit::fromCollection($result['result']);
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotFetchFeeSettings($e->getMessage());
        }
    }

    /**
     * @throws HostAwayException
     */
    public function getReservations(array $params): array
    {
        // check api key before sending request
        $this->checkAccessToken();
        // set up request
        try {
            $reservationRequestBody = new ReservationGetRequestBody($params);
            // Create HostAway request
            $hostaway_req = (new ReservationsGetRequest($reservationRequestBody))->withToken($this->access_token);

            $response = $this->client->send($hostaway_req);

            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return Reservation::fromCollection($result['result']);
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotFetchReservations($e->getMessage());
        }
    }


    public function isClientCredentialsValid(string $client_id, string $client_secret): bool
    {
        try {
            // Create HostAway request
            $hostaway_req = (new AccessTokenGetRequest($client_id, $client_secret));

            $response = $this->client->send($hostaway_req);

            return $response->getStatusCode() == 200;

        } catch (GuzzleException $e) {
            return false;
        }
    }


    public function hasExpiredAccessToken(string $expired_at): bool
    {
        return Carbon::now()->gt(Carbon::parse($expired_at));
    }


    /**
     * @throws HostAwayException
     */
    public function getWebhookReservations(array $params): array
    {
        // check access token before sending request
        $this->checkAccessToken();
        // set up request
        try {
            $requestBody = new WebhookReservationsGetRequestBody($params);
            // Create HostAway request
            $hostaway_req = (new WebhookReservationsGetRequest($requestBody))->withToken($this->access_token);

            $response = $this->client->send($hostaway_req);

            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return Webhook::fromCollection($result['result']);
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotFetchWebhookReservations($e->getMessage());
        }
    }


    /**
     * @throws HostAwayException
     */
    public function getWebhookReservation(int $webhook_id): Webhook
    {
        // check access token before sending request
        $this->checkAccessToken();
        // set up request
        try {
            // Create HostAway request
            $hostaway_req = (new WebhookReservationGetRequest($webhook_id))->withToken($this->access_token);

            $response = $this->client->send($hostaway_req);

            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return new Webhook($result['result']);
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotFetchWebhookReservation($e->getMessage());
        }
    }


    /**
     * @throws HostAwayException
     */
    public function removeWebhookReservations(int $webhook_id): string
    {
        // check access token before sending request
        $this->checkAccessToken();
        // set up request
        try {
            // Create HostAway request
            $hostaway_req = (new WebhookReservationRemoveRequest($webhook_id))->withToken($this->access_token);

            $response = $this->client->send($hostaway_req);

            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return $result['status'];
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotRemoveWebhookReservation($e->getMessage());
        }
    }


    /**
     * @throws HostAwayException
     */
    public function getFinanceStandardField(int $reservationId): FinanceStandardField
    {
        // check access token before sending request
        $this->checkAccessToken();
        // set up request
        try {
            // Create HostAway request
            $hostaway_req = (new FinanceStandardFieldGetRequest($reservationId))->withToken($this->access_token);
            $response = $this->client->send($hostaway_req);

            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return new FinanceStandardField($result['result']);
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotGetFinanceStandardField($e->getMessage());
        }
    }

    /**
     * @throws HostAwayException
     */
    public function createReservation(Reservation $reservation): Reservation
    {
        // check access token before sending request
        $this->checkAccessToken();
        // set up request
        try {

            // Create HostAway request
            $hostaway_req = (new ReservationCreateRequest($reservation))->withToken($this->access_token);
            $response = $this->client->send($hostaway_req);

            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return new Reservation($result['result']);
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotCreateReservation($e->getMessage());
        }
    }

    /**
     * @throws HostAwayException
     */
    public function updateReservation(Reservation $reservation): Reservation
    {
        // check access token before sending request
        $this->checkAccessToken();
        // set up request
        try {

            // Create HostAway request
            $hostaway_req = (new ReservationUpdateRequest($reservation))->withToken($this->access_token);
            $response = $this->client->send($hostaway_req);

            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return new Reservation($result['result']);
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotUpdateReservation($e->getMessage());
        }
    }

    /**
     * @throws HostAwayException
     */
    public function cancelReservation(int $reservationId, string $cancelledBy): Reservation
    {
        // check access token before sending request
        $this->checkAccessToken();
        // set up request
        try {

            // Create HostAway request
            $hostaway_req = (new ReservationCancelRequest($reservationId, $cancelledBy))->withToken($this->access_token);
            $response = $this->client->send($hostaway_req);
            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return new Reservation($result['result']);
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotCancelReservation($e->getMessage());
        }
    }

    /**
     * @throws HostAwayException
     */
    public function getConversations(array $params): array
    {
        // check api key before sending request
        $this->checkAccessToken();
        // set up request
        try {
            $reservationRequestBody = new ConversationsGetRequestBody($params);
            // Create HostAway request
            $hostaway_req = (new ConversationsGetRequest($reservationRequestBody))->withToken($this->access_token);

            $response = $this->client->send($hostaway_req);

            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return Conversation::fromCollection($result['result']);
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotFetchConversations($e->getMessage());
        }
    }

    /**
     * @throws HostAwayException
     */
    public function getConversationMessages(int $conversation_id): array
    {
        // check api key before sending request
        $this->checkAccessToken();
        // set up request
        try {
            // Create HostAway request
            $hostaway_req = (new ConversationMessagesGetRequest($conversation_id))->withToken($this->access_token);

            $response = $this->client->send($hostaway_req);

            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return ConversationMessage::fromCollection($result['result']);
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotFetchConversationMessages($e->getMessage());
        }
    }


    /**
     * @throws HostAwayException
     */
    public function getListingCalendar(int $listing_id, array $params): array
    {
        // check api key before sending request
        $this->checkAccessToken();
        // set up request
        try {
            $calendarGetRequestBody = new CalendarGetRequestBody($params);
            // Create HostAway request
            $hostaway_req = (new CalendarGetRequest($listing_id, $calendarGetRequestBody))->withToken($this->access_token);

            $response = $this->client->send($hostaway_req);

            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return Calendar::fromCollection($result['result']);
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotFetchCalendar($e->getMessage());
        }
    }

    /**
     * @throws HostAwayException
     */
    public function updateCalendar(int $listing_id, Calendar $calendar): array
    {
        // check api key before sending request
        $this->checkAccessToken();
        // set up request
        try {
            // Create HostAway request
            $hostaway_req = (new CalendarUpdateRequest($listing_id, $calendar))->withToken($this->access_token);

            $response = $this->client->send($hostaway_req);

            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return Calendar::fromCollection($result['result']);
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotUpdateCalendar($e->getMessage());
        }
    }


    /**
     * @throws HostAwayException
     */
    public function batchUpdateCalendar(int $listing_id, array $calendars): array
    {
        // check api key before sending request
        $this->checkAccessToken();
        // set up request
        try {
            // Create HostAway request
            $hostaway_req = (new CalendarBatchUpdateRequest($listing_id, $calendars))->withToken($this->access_token);

            $response = $this->client->send($hostaway_req);

            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return Calendar::fromCollection($result['result']);
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotUpdateCalendar($e->getMessage());
        }
    }


    /**
     * @param Listing $listing
     * @return Listing
     * @throws HostAwayException
     */
    public function updateListing(Listing $listing): Listing
    {
        // check access token before sending request
        $this->checkAccessToken();
        // set up request
        try {

            // Create HostAway request
            $hostaway_req = (new ListingUpdateRequest($listing))->withToken($this->access_token);
            $response = $this->client->send($hostaway_req);

            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return new Listing($result['result']);
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotUpdateListing($e->getMessage());
        }
    }

    /**
     * @param CustomField $customField
     * @return CustomField
     * @throws HostAwayException
     */
    public function createCustomField(CustomField $customField): CustomField
    {
        // check access token before sending request
        $this->checkAccessToken();
        // set up request
        try {

            // Create HostAway request
            $hostaway_req = (new CustomFieldCreateRequest($customField))->withToken($this->access_token);
            $response = $this->client->send($hostaway_req);

            // Parse HostAway response
            $result = json_decode($response->getBody()->getContents(), 1);

            return new CustomField($result['result']);
        } catch (GuzzleException $e) {
            throw HostAwayException::couldNotCreateCustomField($e->getMessage());
        }
    }

}