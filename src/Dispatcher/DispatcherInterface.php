<?php

namespace ByTIC\Notifications\Dispatcher;

use ByTIC\Notifications\Notification;
use Nip\Collection;

interface DispatcherInterface
{
    /**
     * Send the given notification to the given notifiable entities.
     *
     * @param  Collection|array|mixed $notifiables
     * @param  mixed $notification
     *
     * @return void
     */
    public function send($notifiables, $notification);


    /**
     * Send the given notification immediately.
     *
     * @param  Collection|array|mixed $notifiables
     * @param  Notification $notification
     * @param  array $channels
     *
     * @return void
     */
    public function sendNow($notifiables, $notification, array $channels = null);
}
