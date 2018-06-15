<?php

namespace ByTIC\Notifications\Tests\Fixtures\Models\Messages;

use ByTIC\Common\Records\Records;
use ByTIC\Notifications\Models\Messages\MessagesTrait;

/**
 * Class Recipient
 * @package ByTIC\Notifications\Tests\Fixtures\Models\Messages
 */
class Messages extends Records
{
    use MessagesTrait;

    /**
     * @return string
     */
    public function getRootNamespace()
    {
        return '\ByTIC\Notifications\Tests\Fixtures\Models\\';
    }
}
