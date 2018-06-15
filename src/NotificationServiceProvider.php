<?php

namespace ByTIC\Notifications;

use ByTIC\Notifications\Channels\ChannelInterface;
use ByTIC\Notifications\Dispatcher\Dispatcher;
use ByTIC\Notifications\Dispatcher\DispatcherInterface;
use Nip\Container\ServiceProvider\AbstractSignatureServiceProvider;

/**
 * Class NotificationServiceProvider
 * @package ByTIC\Notifications
 */
class NotificationServiceProvider extends AbstractSignatureServiceProvider
{

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerChannels();
        $this->registerDispatcher();
    }

    protected function registerChannels()
    {
        $manager = new ChannelManager();
        $this->getContainer()->singleton(ChannelInterface::class, $manager);
    }

    protected function registerDispatcher()
    {
        $dispatcher = new Dispatcher(app(ChannelInterface::class));
        $this->getContainer()->singleton(DispatcherInterface::class, $dispatcher);
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return [ChannelInterface::class, DispatcherInterface::class];
    }
}
