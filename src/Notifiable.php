<?php

namespace ByTIC\Notifications;


/**
 * Class Notifiable
 * @package ByTIC\Notifications
 *
 * @property string $email
 * @property string $phone_number
 */
trait Notifiable
{
    /**
     * Send the given notification.
     *
     * @param  mixed $instance
     * @return void
     */
    public function notify($instance)
    {
        app(Dispatcher::class)->send($this, $instance);
    }

    /**
     * Get the notification routing information for the given driver.
     *
     * @param  string $driver
     * @return mixed
     */
    public function routeNotificationFor($driver)
    {
//        if (method_exists($this, $method = 'routeNotificationFor'.Str::studly($driver))) {
//            return $this->{$method}();
//        }
        switch ($driver) {
//            case 'database':
//                return $this->notifications();
            case 'mail':
                return $this->getNotificationEmail();
            case 'nexmo':
                return $this->getNotificationPhoneNumber();
        }
    }

    public function getNotificationEmail()
    {
        return $this->email;
    }

    public function getNotificationPhoneNumber()
    {
        return $this->phone_number;
    }
}