<?php

namespace ByTIC\Notifications\Tests\Fixtures\Models\Events;

use ByTIC\Notifications\Models\Events\EventsTrait;

/**
 * Class Events
 * @package ByTIC\Notifications\Tests\Fixtures\Models\Events
 */
class Events extends \Nip\Records\RecordManager
{
    use EventsTrait;
}
