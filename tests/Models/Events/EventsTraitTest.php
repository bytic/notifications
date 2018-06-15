<?php

namespace ByTIC\Notifications\Tests\Models\Events;

use ByTIC\Notifications\Models\Events\Statuses\Pending;
use ByTIC\Notifications\Models\Events\Statuses\Sent;
use ByTIC\Notifications\Models\Events\Statuses\Skipped;
use ByTIC\Notifications\Tests\AbstractTest;
use ByTIC\Notifications\Tests\Fixtures\Models\Events\Events;

/**
 * Class EventsTraitTest
 * @package ByTIC\Notifications\Tests\Models\Events
 */
class EventsTraitTest extends AbstractTest
{

    public function testGetStatuses()
    {
        $statuses = Events::instance()->getStatuses();

        self::assertCount(3, $statuses);
        self::assertInstanceOf(Pending::class, $statuses['pending']);
        self::assertInstanceOf(Sent::class, $statuses['sent']);
        self::assertInstanceOf(Skipped::class, $statuses['skipped']);
    }
}
