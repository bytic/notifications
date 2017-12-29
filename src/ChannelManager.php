<?php

namespace ByTIC\Notifications;

use ByTIC\Notifications\Channels\AbstractChannel;
use ByTIC\Notifications\Channels\EmailDbChannel;
use Nip\Collection;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class ChannelManager
 * @package Galantom\Models\Notifications
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
     *
     * @return
     */
    public function send($notifiables, $notification)
    {
        return (new NotificationDispatcher($this))->send($notifiables, $notification);
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
            $this->addChannel($channel, $this->createDriver($channel));
        }

        return $this->getChannel($channel);
    }
    
    public function hasChannel($channel)
    {
        return $this->channels->has($channel);
    }

    protected function addChannel($name, AbstractChannel $driver)
    {
        $this->channels->set($name, $driver);
        return $this;
    }
    
    protected function getChannel($channel)
    {
        return $this->channels->get($channel);
    }

    /**
     * Create a new driver instance.
     *
     * @param  string $driver
     *
     * @return AbstractChannel
     */
    protected function createDriver($driver)
    {
        $method = 'create' . ucfirst($driver) . 'Driver';

        return $this->$method();
    }

    /**
     * Create an instance of the mail driver.
     *
     * @return EmailDbChannel
     */
    protected function createEmailDbDriver()
    {
        return new EmailDbChannel();
    }
}