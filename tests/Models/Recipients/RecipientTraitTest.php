<?php

namespace ByTIC\Notifications\Tests\Models\Recipients;

use ByTIC\Notifications\Models\Recipients\Types\Single;
use ByTIC\Notifications\Tests\AbstractTest;
use ByTIC\Notifications\Tests\Fixtures\Models\Events\Event;
use ByTIC\Notifications\Tests\Fixtures\Models\Recipients\Recipient;
use ByTIC\Notifications\Tests\Fixtures\Models\Recipients\Recipients;

use Mockery as m;

/**
 * Class RecipientTraitTest
 * @package ByTIC\Notifications\Tests\Models\Recipients
 */
class RecipientTraitTest extends AbstractTest
{
    public function testSend()
    {
        $recipient = new Recipient();

        $type = m::mock(Single::class)
            ->shouldReceive('sendEvent')->andReturn(1);

        $recipients = m::mock(Recipients::class)
            ->shouldReceive('getType')->andReturn($type);
        $recipient->setManager($recipients);

        $event = new Event();

        $result = $recipient->sendEvent($event);
        self::assertTrue($result);
    }
}
