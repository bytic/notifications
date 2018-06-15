<?php

namespace ByTIC\Notifications\Tests\Models\Recipients;

use ByTIC\Notifications\Models\Recipients\Types\Collection;
use ByTIC\Notifications\Models\Recipients\Types\Single;
use ByTIC\Notifications\Tests\AbstractTest;
use ByTIC\Notifications\Tests\Fixtures\Models\Recipients\Recipients;

/**
 * Class RecipientsTraitTest
 * @package ByTIC\Notifications\Tests\Models\Recipients
 */
class RecipientsTraitTest extends AbstractTest
{

    public function testGetTypes()
    {
        $types = Recipients::instance()->getTypes();

        self::assertCount(2, $types);
        self::assertInstanceOf(Collection::class, $types['collection']);
        self::assertInstanceOf(Single::class, $types['single']);
    }
}
