<?php

namespace ByTIC\Notifications\Dispatcher;

use ByTIC\Notifications\ChannelManager;
use Nip\Collection;

/**
 * Class NotificationSender
 * Used to send a notification
 *
 * @package Galantom\Models\Notifications
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
        $notifiables = $this->formatNotifiables($notifiables);

        $this->sendNow($notifiables, $notification);
    }

    /**
     * Format the notifiables into a Collection / array if necessary.
     *
     * @param  mixed $notifiables
     *
     * @return Collection|array
     */
    protected function formatNotifiables($notifiables)
    {
        if (!$notifiables instanceof Collection && !is_array($notifiables)) {
            return $notifiables instanceof Record
                ? new Collection([$notifiables]) : [$notifiables];
        }

        return $notifiables;
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
     * Send the given notification to the given notifiable via a channel.
     *
     * @param  mixed $notifiable
     * @param  string $id
     * @param  mixed $notification
     * @param  string $channel
     *
     * @return void
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
    }

}