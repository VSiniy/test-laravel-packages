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
            __DIR__.'/../config/activity.php' => config_path('activity.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__.'/../config/activity.php', 'activity');

        $viewPath = __DIR__.'/../resources/views';
        $this->loadViewsFrom($viewPath, 'activity');
        $this->publishes([
            $viewPath => base_path('resources/views/vendor/activity'),
        ], 'views');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/activity.php';
        $this->mergeConfigFrom($configPath, 'activity');
        $this->publishes([$configPath => config_path('activity.php')], 'config');
    }
}
