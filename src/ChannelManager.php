<?php

namespace ByTIC\Notifications;

use ByTIC\Notifications\Channels\AbstractChannel;
use ByTIC\Notifications\Channels\EmailDbChannel;
use ByTIC\Notifications\Dispatcher\Dispatcher;
use Nip\Collection;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class ChannelManager
 * @package ByTIC\Notifications
 */
class ChannelManager
{
    use SingletonTrait;

    /**
     * The array of created "drivers".
     *
     * @var AbstractChannel[]
     */
    protected $channels = null;
    
    public function __construct()
    {
        $this->channels = new Collection();
    }

    /**
     * @param Collection $notifiables
     * @param Notification $notification
     */
    public function send($notifiables, $notification)
    {
        return (new Dispatcher($this))->send($notifiables, $notification);
    }

    /**
     * Get a driver instance.
     *
     * @param  string $channel
     *
     * @return AbstractChannel
     */
    public function channel($channel = null)
    {
        // If the given driver has not been created before, we will create the instances
        // here and cache it so we can return it next time very quickly. If there is
        // already a driver created by this name, we'll just return that instance.
        if (!$this->hasChannel($channel)) {
            $this->addChannel($channel, $this->createChannel($channel));
        }

        return $this->getChannel($channel);
    }

    /**
     * @param $channel
     * @return bool
     */
    public function hasChannel($channel)
    {
        return $this->channels->has($channel);
    }

    /**
     * @param $name
     * @param AbstractChannel $driver
     * @return $this
     */
    protected function addChannel($name, AbstractChannel $driver)
    {
        $this->channels->set($name, $driver);
        return $this;
    }

    /**
     * @param $channel
     * @return mixed
     */
    protected function getChannel($channel)
    {
        return $this->channels->get($channel);
    }

    /**
     * Create a new driver instance.
     *
     * @param  string $channel
     *
     * @return AbstractChannel
     */
    protected function createChannel($channel)
    {
        $method = 'create' . ucfirst($channel) . 'Channel';

        return $this->$method();
    }

    /**
     * Create an instance of the mail driver.
     *
     * @return EmailDbChannel
     */
    protected function createEmailDbChannel()
    {
        return new EmailDbChannel();
    }
}
