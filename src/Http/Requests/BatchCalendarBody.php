<?php

namespace Backend\HostawaySdkLaravel\Http\Requests;

use Backend\HostawaySdkLaravel\Exceptions\JsonEncodingException;


class BatchCalendarBody
{

    public array $calendars;

    public function __construct(array $calendars)
    {
        $this->calendars = $calendars;
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
        $data = [];
        foreach ($this->calendars as $calendar) {
            $data[] = [
                'startDate' => $calendar->startDate,
                'endDate' => $calendar->endDate,
                'isAvailable' => $calendar->isAvailable,
                'isProcessed' => $calendar->isProcessed,
                'price' => $calendar->price,
                'note' => $calendar->note,
            ];
        }
        return $data;
    }
}
