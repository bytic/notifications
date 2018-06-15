<?php

namespace ByTIC\Notifications\Tests\Fixtures\Models\Events;

use ByTIC\Common\Records\Record;
use ByTIC\Notifications\Models\Events\EventTrait;

/**
 * Class Events
 * @package ByTIC\Notifications\Tests\Fixtures\Models\Events
 */
class Event extends Record
{
    use EventTrait;
}
