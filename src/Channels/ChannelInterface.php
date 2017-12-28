<?php

namespace ByTIC\Notifications\Channels;

use ByTIC\Notifications\Notification;

interface ChannelInterface
{

    /**
     * @param $notifiable
     * @param Notification $notification
     * @return int
     */
    public function send($notifiable, Notification $notification);

}
