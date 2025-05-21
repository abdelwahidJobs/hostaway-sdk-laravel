<?php

namespace Backend\HostawaySdkLaravel;

use Backend\HostawaySdkLaravel\Http\Client\HostAwayHttpClient;
use Backend\HostawaySdkLaravel\Http\Environment\HostAwayEnvironment;
use Illuminate\Support\ServiceProvider;

class HostawayServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/services.php',
            'services'
        );

        $this->app->singleton(HostAwayHttpClient::class, function () {
            $api_url = config('services.hostaway.api_url');

            return new HostAwayHttpClient(new HostAwayEnvironment($api_url));
        });

        $this->app->singleton(HostAwayService::class, function () {
            return new HostAwayService(app(HostAwayHttpClient::class));
        });
    }

    /** @return array */
    public function provides(): array
    {
        return [HostAwayHttpClient::class, HostAwayService::class];
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/services.php' => config_path('services.php'),
        ], 'hostaway-config');

    }


}