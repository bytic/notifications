<?php

namespace ByTIC\Notifications;

use ByTIC\Notifications\Dispatcher\Dispatcher;
use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;

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
        $this->getContainer()->share('notifications.channels', $manager);
    }

    protected function registerDispatcher()
    {
        $dispatcher = new Dispatcher(app('notifications.channels'));
        $this->getContainer()->share('notifications.dispatcher', $dispatcher);
    }

    /*
     * @inheritdoc
     */
    public function provides()
    {
        return ['notifications.channels', 'notifications.dispatcher'];
    }
}
