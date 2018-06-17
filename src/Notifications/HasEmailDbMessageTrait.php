<?php

namespace ByTIC\Notifications\Notifications;

use ByTIC\Notifications\Messages\Builder\EmailBuilder;

/**
 * Trait HasEmailDbMessageTrait
 * @package ByTIC\Notifications\Notifications
 */
trait HasEmailDbMessageTrait
{

    /**
     * @param $notifiable
     * @return mixed
     */
    public function toMailDb($notifiable)
    {
        /** @var EmailBuilder $emailBuilder */
        $emailBuilder = $this->generateEmailMessage();
        $emailBuilder->setNotifiable($notifiable);
        return $emailBuilder->createEmail();
    }

    /**
     * @return EmailBuilder
     */
    public function generateEmailMessage()
    {
        $class = $this->generateEmailMessageClass();
        /** @var EmailBuilder $message */
        $message = new $class();
//        $this->populateEmailMessage($message);
        return $message;
    }

    /**
     * @return string
     */
    public function generateEmailMessageClass()
    {
        return EmailBuilder::class;
    }
}
