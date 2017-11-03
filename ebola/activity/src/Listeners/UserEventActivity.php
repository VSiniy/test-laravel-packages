<?php

namespace Ebola\Activity\Listeners;

class UserEventActivity
{
    /**
     * Handle user registered events.
     */
    public function onUserRegistered($event) 
    {
        activity('user-registered')->log('User registered');
    }

    /**
     * Handle user attempting events.
     */
    public function onUserAttempting($event) 
    {
        activity('user-attempting')->log('User attempting');
    }

    /**
     * Handle user authenticated events.
     */
    public function onUserAuthenticated($event) 
    {
        activity('user-authenticated')->log('User authenticated');
    }

    /**
     * Handle user login events.
     */
    public function onUserLogin($event) 
    {
        activity('user-login')->log('User login');
    }

    /**
     * Handle user failed events.
     */
    public function onUserFailed($event) 
    {
        activity('user-failed-auth')->log('User failed');
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event) 
    {
        activity('user-logout')->log('User logout');
    }

    /**
     * Handle user lockout events.
     */
    public function onUserLockout($event) 
    {
        activity('user-lockout')->log('User lockout');
    }

    /**
     * Handle user password reset events.
     */
    public function onUserPasswordReset($event) 
    {
        activity('user-password-reset')->log('User password reset');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Registered',
            'Ebola\Activity\Listeners\UserEventActivity@onUserRegistered'
        );

        $events->listen(
            'Illuminate\Auth\Events\Attempting',
            'Ebola\Activity\Listeners\UserEventActivity@onUserAttempting'
        );

        // $events->listen(
        //     'Illuminate\Auth\Events\Authenticated',
        //     'Ebola\Activity\Listeners\UserEventActivity@onUserAuthenticated'
        // );

        $events->listen(
            'Illuminate\Auth\Events\Login',
            'Ebola\Activity\Listeners\UserEventActivity@onUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Failed',
            'Ebola\Activity\Listeners\UserEventActivity@onUserFailed'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'Ebola\Activity\Listeners\UserEventActivity@onUserLogout'
        );

        $events->listen(
            'Illuminate\Auth\Events\Lockout',
            'Ebola\Activity\Listeners\UserEventActivity@onUserLockout'
        );

        $events->listen(
            'Illuminate\Auth\Events\PasswordReset',
            'Ebola\Activity\Listeners\UserEventActivity@onUserPasswordReset'
        );
    }
}