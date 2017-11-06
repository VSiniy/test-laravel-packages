<?php

namespace Ebola\Activity;

use Illuminate\Support\ServiceProvider;

class ActivityServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/activity.php' => config_path('activity.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/resources/views' => base_path('resources/views/vendor/activity'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/resources/assets' => public_path('vendor/activity'),
        ], 'public');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/activity.php', 'activity');
    }
}
