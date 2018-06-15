<?php

namespace ByTIC\Notifications\Channels;

use ByTIC\Notifications\Notification;

/**
 * Interface ChannelInterface
 * @package ByTIC\Notifications\Channels
 */
interface ChannelInterface
{
    /**
     * @param $notifiable
     * @param Notification $notification
     * @return int
     */
    public function send($notifiable, Notification $notification);
}
