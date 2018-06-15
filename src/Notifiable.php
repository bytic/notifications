<?php

namespace ByTIC\Notifications;

use ByTIC\Notifications\Dispatcher\DispatcherInterface;

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
     * @param  Notification $notification
     *
     * @return void
     */
    public function notify($notification)
    {
        app(DispatcherInterface::class)->send($this, $notification);
    }

    /**
     * Get the notification routing information for the given driver.
     *
     * @param  string $driver
     *
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

        return null;
    }

    /**
     * @return string
     */
    public function getNotificationEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getNotificationPhoneNumber()
    {
        return $this->phone_number;
    }
}
