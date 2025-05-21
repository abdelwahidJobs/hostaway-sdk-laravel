<?php


namespace Backend\HostawaySdkLaravel\Http\Requests;


use Backend\HostawaySdkLaravel\Dto\CustomField;
use Backend\HostawaySdkLaravel\Exceptions\JsonEncodingException;

class CustomFieldBody
{

    public CustomField $customField;

    public function __construct(CustomField $customField)
    {
        $this->customField = $customField;
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
            "name" => $this->customField->name,
            "varName" => $this->customField->varName,
            "possibleValues" => $this->customField->possibleValues,
            "type" => $this->customField->type,
            "objectType" => $this->customField->objectType,
            "isPublic" => $this->customField->isPublic,
            "sortOrder" => $this->customField->sortOrder,
        ];

    }
}
