<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

use Backend\HostawaySdkLaravel\Dto\Calendar;
use Wechalet\HostAway\Exceptions\JsonEncodingException;

class CalendarBody
{

    public Calendar $calendar;

    public function __construct(Calendar $calendar)
    {
        $this->calendar = $calendar;
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
            'startDate' => $this->calendar->startDate,
            'endDate' => $this->calendar->endDate,
            'isAvailable' => $this->calendar->isAvailable,
            'isProcessed' => $this->calendar->isProcessed,
            'price' => $this->calendar->price,
            'minimumStay' => $this->calendar->minimumStay,
            'maximumStay' => $this->calendar->maximumStay,
            'closedOnArrival' => $this->calendar->closedOnArrival,
            'closedOnDeparture' => $this->calendar->closedOnDeparture,
            'note' => $this->calendar->note,
        ];

    }
}
