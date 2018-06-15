<?php

namespace ByTIC\Notifications\Dispatcher;

use ByTIC\Notifications\ChannelManager;
use Nip\Collections\Collection;
use Nip\Records\AbstractModels\Record;

/**
 * Class NotificationSender
 * Used to send a notification
 *
 * @package ByTIC\Notifications\Dispatcher
 */
class Dispatcher implements DispatcherInterface
{

    /**
     * The notification manager instance.
     *
     * @var ChannelManager
     */
    protected $manager;

    /**
     * Create a new notification sender instance.
     *
     * @param ChannelManager $manager
     */
    public function __construct($manager)
    {
        $this->manager = $manager;
    }

    /**
     * @inheritdoc
     */
    public function send($notifiables, $notification)
    {
        $this->sendNow($notifiables, $notification);
    }

    /**
     * @inheritdoc
     */
    public function sendNow($notifiables, $notification, array $channels = null)
    {
        $notifiables = $this->formatNotifiables($notifiables);
        $original = clone $notification;
        foreach ($notifiables as $notifiable) {
            $notificationId = microtime();

            if (empty($viaChannels = $channels ?: $notification->via($notifiable))) {
                continue;
            }

            foreach ($viaChannels as $channel) {
                $this->sendToNotifiable($notifiable, $notificationId, clone $original, $channel);
            }
        }
    }

    /**
     * Format the notifiables into a Collection / array if necessary.
     *
     * @param  mixed $notifiables
     *
     * @return Collection|array
     */
    public function formatNotifiables($notifiables)
    {
        if (is_array($notifiables) || $notifiables instanceof Collection) {
            return $notifiables;
        }

        if ($notifiables instanceof Record) {
            return new Collection([$notifiables]);
        }

        return [$notifiables];
    }

    /**
     * Send the given notification to the given notifiable via a channel.
     *
     * @param  mixed $notifiable
     * @param  string $id
     * @param  mixed $notification
     * @param  string $channel
     *
     * @return int
     */
    protected function sendToNotifiable($notifiable, $id, $notification, $channel)
    {
        if (!$notification->id) {
            $notification->id = $id;
        }
//        if (! $this->shouldSendNotification($notifiable, $notification, $channel)) {
//            return;
//        }
        $response = $this->manager->channel($channel)->send($notifiable, $notification);

//        $this->events->dispatch(
//            new Events\NotificationSent($notifiable, $notification, $channel, $response)
//        );
        return $response;
    }
}
