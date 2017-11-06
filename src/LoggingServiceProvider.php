<?php

namespace Ebola\Logging;

use Illuminate\Support\ServiceProvider;

class  LoggingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/logging.php' => config_path('logging.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/resources/views' => base_path('resources/views/vendor/logging'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/resources/assets' => public_path('vendor/logging'),
        ], 'public');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/logging.php', 'logging');
    }
}
