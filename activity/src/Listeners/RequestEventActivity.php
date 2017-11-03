<?php

namespace Ebola\Activity\Listeners;

class RequestEventActivity
{
    /**
     * Handle user go to route.
     */
    public function onGoToRoute($event) 
    {
        if ((strpos($event->request->getRequestUri(), env('ROUTING_LOG')) !== false)) {
            $url = route('home') . ((strpos($event->request->getRequestUri(), '?') !== false) ? substr($event->request->getRequestUri(), 0, strpos($event->request->getRequestUri(), '?')) : $event->request->getRequestUri());

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
            'Illuminate\Foundation\Http\Events\RequestHandled',
            'Ebola\Activity\Listeners\RequestEventActivity@onGoToRoute'
        );
    }
}