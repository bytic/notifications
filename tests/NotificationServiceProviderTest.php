<?php

namespace ByTIC\Notifications\Tests;

use ByTIC\Notifications\ChannelManager;
use ByTIC\Notifications\Channels\ChannelInterface;
use ByTIC\Notifications\Dispatcher\Dispatcher;
use ByTIC\Notifications\Dispatcher\DispatcherInterface;
use ByTIC\Notifications\NotificationServiceProvider;
use Nip\Container\Container;

/**
 * Class NotificationServiceProviderTest
 * @package ByTIC\Notifications\Tests
 */
class NotificationServiceProviderTest extends AbstractTest
{
    public function testAliases()
    {
        $container = new Container();
        Container::setInstance($container);

        $provider = new NotificationServiceProvider();
        $provider->setContainer($container);
        $provider->register();

        $channelManager = $container->get(ChannelInterface::class);
        static::assertInstanceOf(ChannelManager::class, $channelManager);

        $dispatcher = $container->get(DispatcherInterface::class);
        static::assertInstanceOf(Dispatcher::class, $dispatcher);
    }
}
