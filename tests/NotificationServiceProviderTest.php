<?php

namespace ByTIC\Notifications\Tests;

use ByTIC\Notifications\ChannelManager;
use ByTIC\Notifications\Channels\MailDbChannel;
use ByTIC\Notifications\Dispatcher\Dispatcher;
use ByTIC\Notifications\NotificationServiceProvider;
use Nip\Container\Container;

class NotificationServiceProviderTest extends AbstractTest
{
    
    public function testAliases()
    {
        $container = Container::getInstance();

        $provider = new NotificationServiceProvider();
        $provider->setContainer($container);
        $provider->register();

        $channelManager = $container->get('notifications.channels');
        $this->assertInstanceOf(ChannelManager::class, $channelManager);

        $dispatcher = $container->get('notifications.dispatcher');
        $this->assertInstanceOf(Dispatcher::class, $dispatcher);
    }

}
