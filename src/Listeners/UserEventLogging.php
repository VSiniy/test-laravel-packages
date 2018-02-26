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
        activity('user-registered')->log(self::getMessage($event, self::EVENT_REGISTERED));
    }

    /**
     * Handle user attempting events.
     */
    public function onUserAttempting($event) 
    {
        activity('user-attempting')->log(self::getMessage($event, self::EVENT_ATTEMPTING));
    }

    /**
     * Handle user authenticated events.
     */
    public function onUserAuthenticated($event) 
    {
        if (!\Request::ajax())
            activity('user-authenticated')->log(self::getMessage($event, self::EVENT_AUTHENTICATED));
    }

    /**
     * Handle user login events.
     */
    public function onUserLogin($event) 
    {
        activity('user-login')->log(self::getMessage($event, self::EVENT_LOGIN));
    }

    /**
     * Handle user failed events.
     */
    public function onUserFailed($event) 
    {
        activity('user-failed-auth')->log(self::getMessage($event, self::EVENT_FAILED));
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event) 
    {
        activity('user-logout')->log(self::getMessage($event, self::EVENT_LOGOUT));
    }

    /**
     * Handle user lockout events.
     */
    public function onUserLockout($event) 
    {
        activity('user-lockout')->log(self::getMessage($event, self::EVENT_LOCKOUT));
    }

    /**
     * Handle user password reset events.
     */
    public function onUserPasswordReset($event) 
    {
        activity('user-password-reset')->log(self::getMessage($event, self::EVENT_PASSWORD_RESET));
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

    private static function getMessage($event, $key) 
    {
        $message = '';

        if (!is_null($event->user) && !is_null($event->user->guard)) {
            $message .= title_case($event->user->guard) . ' ';
        } else {
            $message .= title_case(config('auth.defaults.guard')));
        }

        $message .= 'user ';

        if (!is_null($event->user) && !is_null($event->user->email)) {
            $message .= 'with email ' . title_case($event->user->email) . ' ';
        }

        switch($key) {
            case self::EVENT_REGISTERED:
                $message .= 'registered'; 

            case self::EVENT_ATTEMPTING:
                $message .= 'attempting'; 

            case self::EVENT_AUTHENTICATED:
                $message .= 'authenticated'; 
                
            case self::EVENT_LOGIN:
                $message .= 'login'; 

            case self::EVENT_FAILED:
                $message .= 'failed'; 

            case self::EVENT_LOGOUT: 
                $message .= 'logout'; 

            case self::EVENT_LOCKOUT: 
                $message .= 'lockout'; 

            case self::EVENT_PASSWORD_RESET: 
                $message .= 'password reset'; 
        }

        return $message;
    }
}