<?php

namespace Ebola\Logging\Listeners;

class RequestEventLogging
{
    const WEB_SITE_PREFIX = 'web';

    /**
     * Handle user go to route.
     */
    public function onGoToRoute($event) 
    {
        $loggingRoutes = config('logging.logging_routing_prefixes');

        $webKey        = array_search(self::WEB_SITE_PREFIX, $loggingRoutes);

        if ($webKey !== false) 
            $loggingRoutes = array_replace($loggingRoutes, [$webKey => null]);

        $routePrefix = trim($event->request->route()->getPrefix(), '/');
        $routeUri    = $event->request->getRequestUri();
        $homeUrl     = $event->request->getSchemeAndHttpHost();

        if (in_array($routePrefix, $loggingRoutes)) {
            if (!$event->request->ajax() || ($event->request->ajax() && config('logging.logging_routing_save_ajax'))) {
                $url = $homeUrl . ((strpos($routeUri, '?') !== false) ? substr($routeUri, 0, strpos($routeUri, '?')) : $routeUri);

                activity('route')->log('Go to url ' . $url);
            }
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
            'Illuminate\Foundation\Http\Events\RequestHandled',
            'Ebola\Logging\Listeners\RequestEventLogging@onGoToRoute'
        );
    }
}