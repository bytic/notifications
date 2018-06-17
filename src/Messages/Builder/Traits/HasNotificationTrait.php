<?php

namespace ByTIC\Notifications\Messages\Builder\Traits;

use ByTIC\Notifications\Notification;

/**
 * Trait HasNotificationTrait
 * @package ByTIC\Notifications\Messages\Builder\Traits
 */
trait HasNotificationTrait
{
    /**
     * @var Notification
     */
    protected $notification = null;


    /**
     * @return Notification
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * Set the Notification instance
     *
     * @param Notification $notification Notification instance
     *
     * @return void
     */
    public function setNotification($notification)
    {
        $this->notification = $notification;
    }
}
