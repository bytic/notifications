<?php

namespace ByTIC\Notifications\Notifications;

use ByTIC\Notifications\Messages\Builder\EmailBuilder;

/**
 * Trait HasEmailDbMessageTrait
 * @package ByTIC\Notifications\Notifications
 */
trait HasEmailDbMessageTrait
{
    use HasMessageBuilderTrait;

    /**
     * @param $notifiable
     * @return mixed
     */
    public function toMailDb($notifiable)
    {
        /** @var EmailBuilder $emailBuilder */
        $emailBuilder = $this->generateMessageBuilder('mail');
        $emailBuilder->setNotifiable($notifiable);
        return $emailBuilder->createEmail();
    }
}
