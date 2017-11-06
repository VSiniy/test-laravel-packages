<?php

namespace Ebola\Logging\Listeners;

class RouteEventLogging
{
    /**
     * Handle user go to route.
     */
    public function onGoToRoute($event) 
    {
        if (str_replace('/', '', $event->route->action['prefix']) == env('ROUTING_LOG')) {
            $url = route('home') . (($event->route->action['as'] != 'home') ? '/' : '') . $event->route->uri;

            activity('route')->log('Go to url ' . $url);
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Routing\Events\RouteMatched',
            'Ebola\Logging\Listeners\RouteEventLogging@onGoToRoute'
        );
    }
}