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

    /**
     * @param $notification
     * @param $recipient
     * @param $target
     * @param $trigger
     *
     * @dataProvider generateNotificationNameData
     */
    public function testGenerateNotificationName($notification, $recipient, $target, $trigger)
    {
        self::assertSame($notification, Recipients::generateNotificationName($recipient, $target, $trigger));
    }

    /**
     * @return array
     */
    public function generateNotificationNameData()
    {
        $base = '\ByTIC\Notifications\Tests\Fixtures\Models\\';
        return [
            [
                $base . 'OrgSupporters\Notifications\Fundraising_Pages\PendingNotification',
                'org_supporters',
                'fundraising-page',
                'pending'
            ],
            [
                $base . 'OrgSupporters\Notifications\FundraisingPages\PendingNotification',
                'org_supporters',
                'fundraising_page',
                'pending'
            ],
        ];
    }
}
