<?php

namespace Backend\HostawaySdkLaravel\Http\Environment;

interface Environment
{
    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return string
     */
    public function baseUrl(): string;

    /**
     * @return array
     */
    public function authorizationHeaders(): array;
}
