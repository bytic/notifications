<?php

namespace ByTIC\Notifications\Tests\Fixtures\Models\Recipients;

use ByTIC\Common\Records\Records;
use ByTIC\Notifications\Models\Recipients\RecipientsTrait;

/**
 * Class Recipient
 * @package ByTIC\Notifications\Tests\Fixtures\Models\Recipients
 */
class Recipients extends Records
{
    use RecipientsTrait;

    /**
     * @return string
     */
    public function getRootNamespace()
    {
        return '\ByTIC\Notifications\Tests\Fixtures\Models\\';
    }
}
