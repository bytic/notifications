<?php

namespace ByTIC\Notifications;

use ByTIC\Notifications\Notifications\AbstractNotification;
use ByTIC\Notifications\Notifications\HasEmailDbMessageTrait;

/**
 * Class Notification
 * @package ByTIC\Notifications
 */
class Notification extends AbstractNotification
{
    use HasEmailDbMessageTrait;
}
