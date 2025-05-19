<?php

namespace Backend\HostawaySdkLaravel\Traits;

trait HasCollection
{
    public static function fromCollection(array $listings): array
    {
        return array_map(
            fn(array $data) => new self($data),
            $listings
        );
    }

}
