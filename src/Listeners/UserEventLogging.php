<?php

namespace Ebola\Logging\Listeners;

class UserEventLogging
{
    const EVENT_REGISTERED     = 'registered';
    const EVENT_ATTEMPTING     = 'attempting';
    const EVENT_AUTHENTICATED  = 'authenticated';
    const EVENT_LOGIN          = 'login';
    const EVENT_FAILED         = 'failed';
    const EVENT_LOGOUT         = 'logout';
    const EVENT_LOCKOUT        = 'lockout';
    const EVENT_PASSWORD_RESET = 'password_reset';

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
        if (!\Request::ajax())
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
        $loggingUsersEvents = config('logging.logging_users_events');

        if (in_array(self::EVENT_REGISTERED, $loggingUsersEvents))
            $events->listen(
                'Illuminate\Auth\Events\Registered',
                'Ebola\Logging\Listeners\UserEventLogging@onUserRegistered'
            );

        if (in_array(self::EVENT_ATTEMPTING, $loggingUsersEvents))
            $events->listen(
                'Illuminate\Auth\Events\Attempting',
                'Ebola\Logging\Listeners\UserEventLogging@onUserAttempting'
            );

        if (in_array(self::EVENT_AUTHENTICATED, $loggingUsersEvents))
            $events->listen(
                'Illuminate\Auth\Events\Authenticated',
                'Ebola\Logging\Listeners\UserEventLogging@onUserAuthenticated'
            );

        if (in_array(self::EVENT_LOGIN, $loggingUsersEvents))
            $events->listen(
                'Illuminate\Auth\Events\Login',
                'Ebola\Logging\Listeners\UserEventLogging@onUserLogin'
            );

        if (in_array(self::EVENT_FAILED, $loggingUsersEvents))
            $events->listen(
                'Illuminate\Auth\Events\Failed',
                'Ebola\Logging\Listeners\UserEventLogging@onUserFailed'
            );

        if (in_array(self::EVENT_LOGOUT, $loggingUsersEvents))
            $events->listen(
                'Illuminate\Auth\Events\Logout',
                'Ebola\Logging\Listeners\UserEventLogging@onUserLogout'
            );

        if (in_array(self::EVENT_LOCKOUT, $loggingUsersEvents))
            $events->listen(
                'Illuminate\Auth\Events\Lockout',
                'Ebola\Logging\Listeners\UserEventLogging@onUserLockout'
            );

        if (in_array(self::EVENT_PASSWORD_RESET, $loggingUsersEvents))
            $events->listen(
                'Illuminate\Auth\Events\PasswordReset',
                'Ebola\Logging\Listeners\UserEventLogging@onUserPasswordReset'
            );
    }
}