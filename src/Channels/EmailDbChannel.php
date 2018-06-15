<?php

namespace ByTIC\Notifications\Channels;

use ByTIC\Notifications\Notification;

/**
 * Class MailChannel
 * @package ByTICModels\Notifications\Channels
 */
class EmailDbChannel extends AbstractChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed $notifiable
     * @param  Notification $notification
     * @return int
     */
    public function send($notifiable, Notification $notification)
    {
        $email = $notification->toMailDb($notifiable);
        $email->save();
        if ($email->id > 0) {
            return 1;
        }
        return 0;
    }
}
