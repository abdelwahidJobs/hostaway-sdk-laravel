<?php

namespace Backend\HostawaySdkLaravel\Http\Environment;

class HostAwayEnvironment implements Environment
{
    private string $base_url;

    /**
     * @param string $base_url
     */
    public function __construct(string $base_url = '')
    {
        $this->base_url = $base_url;
    }

    /** @inheritDoc */
    public function name(): string
    {
        return 'production';
    }

    /** @inheritDoc */
    public function baseUrl(): string
    {
        return $this->base_url;
    }

    /** @inheritDoc */
    public function authorizationHeaders(): array
    {
        return [];
    }
}
