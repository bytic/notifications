<?php

namespace ByTIC\Notifications\Channels;

use ByTIC\Notifications\Notification;

/**
 * Class AbstractChannel
 * @package ByTICModels\Notifications\Channels
 */
abstract class AbstractChannel
{

    /**
     * @param $notifiable
     * @param Notification $notification
     * @return int
     */
    abstract public function send($notifiable, Notification $notification);

}