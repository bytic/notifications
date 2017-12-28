<?php

namespace ByTIC\Notifications\Tests;

use ByTIC\Notifications\ChannelManager;
use ByTIC\Notifications\Channels\ChannelInterface;
use ByTIC\Notifications\Channels\MailDbChannel;
use ByTIC\Notifications\Dispatcher\Dispatcher;
use ByTIC\Notifications\Dispatcher\DispatcherInterface;
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

        $channelManager = $container->get(ChannelInterface::class);
        $this->assertInstanceOf(ChannelManager::class, $channelManager);

        $dispatcher = $container->get(DispatcherInterface::class);
        $this->assertInstanceOf(Dispatcher::class, $dispatcher);
    }

}
