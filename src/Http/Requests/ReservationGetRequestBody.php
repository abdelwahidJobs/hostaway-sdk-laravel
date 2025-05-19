<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

/**
 * ref https://api.hostaway.com/documentation#retrieve-a-reservations-list
 * limit    no    int    Maximum number of items in the list.
 * offset    no    int    Number of items to skip from beginning of the list.
 * sortOrder    no    string    One of: arrivalDate, arrivalDateDesc, lastConversationMessageSent, lastConversationMessageSentDesc, lastConversationMessageReceived, lastConversationMessageReceivedDesc, latestActivity, latestActivityDesc.
 * channelId    no    int
 * listingId    no    int
 * assigneeUserId    no    int
 * match    no    string    Used to search a reservation by guest name.
 * arrivalStartDate    no    date
 * arrivalEndDate    no    date
 * departureStartDate    no    date
 * departureEndDate    no    date
 * hasUnreadConversationMessages    no    bool
 * isStarred    no    bool
 * isArchived    no    bool
 * isPinned    no    bool
 * customerUserId    no    string
 * includeResources    no    int    if includeResources flag is 1 then response object is supplied with supplementary resources, default is 1.
 * latestActivityStart    no    date
 * latestActivityEnd    no    date
 */
class ReservationGetRequestBody
{
    public array $query;

    public function __construct(array $query)
    {
        $this->query = $query;
    }

    public function addItem(string $key, $value)
    {
        $this->query[$key] = $value;
    }

    public function getQuery(): string
    {
        return http_build_query($this->query);
    }

}
