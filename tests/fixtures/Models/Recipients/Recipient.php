<?php

namespace ByTIC\Notifications\Tests\Fixtures\Models\Recipients;

use ByTIC\Common\Records\Record;
use ByTIC\Notifications\Models\Recipients\RecipientTrait;

/**
 * Class Recipient
 * @package ByTIC\Notifications\Tests\Fixtures\Models\Recipients
 */
class Recipient extends Record
{
    use RecipientTrait;
}
