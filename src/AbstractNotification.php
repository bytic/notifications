<?php

namespace ByTIC\Notifications;

use ByTIC\Notifications\Events\Event;
use ByTIC\Notifications\Messages\Builder\EmailBuilder;
use ByTIC\Notifications\Messages\Message;
use ByTIC\Notifications\Messages\Messages;
use Record;

/**
 * Class Notification
 *
 */
abstract class AbstractNotification
{

    /**
     * @var Event
     */
    protected $event = null;

    /**
     * Notification Message
     *
     * @var Message
     */
    protected $notificationMessage = null;

    /**
     * Notification constructor.
     *
     * @param Event $event
     */
    public function __construct(Event $event = null)
    {
        if ($event) {
            $this->setEvent($event);
        }
    }

    /**
     * @param Record $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mailDb'];
    }

    /**
     * @return EmailBuilder
     */
    public function generateEmailMessage()
    {
        $class = $this->generateEmailMessageClass();
        /** @var EmailBuilder $message */
        $message = new $class();
        $this->populateEmailMessage($message);
        return $message;
    }

    /**
     * @return string
     */
    public function generateEmailMessageClass()
    {
        return EmailBuilder::class;
    }

    /**
     * @param EmailBuilder $message
     * @return mixed
     */
    protected function populateEmailMessage($message)
    {
        $message->setNotification($this);
        $model = $this->getEvent() ? $this->getEvent()->getModel() : null;
        if ($model) {
            $message->setItem($model);
        }
        return $message;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param Event $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * Instances and returns the Notification Message Record
     *
     * @return Message
     */
    public function getNotificationMessage()
    {
        if ($this->notificationMessage == null) {
            $this->initNotificationMessage();
        }
        return $this->notificationMessage;
    }

    /**
     * Instances the Notigication Record
     *
     * @return void
     */
    protected function initNotificationMessage()
    {
        $this->notificationMessage = $this->generateNotificationMessage();
    }

    /**
     * Return the Message from the database with the text to include
     * in the notification
     *
     * @return Message
     */
    protected function generateNotificationMessage()
    {
        return Messages::getGlobal(
            $this->getEvent()->getTopic(),
            $this->getRecipientName(),
            'email'
        );
    }

    /**
     * @return string
     */
    abstract public function getRecipientName();

    /**
     * @param $notifiable
     * @return mixed
     */
    abstract public function toMailDb($notifiable);
}
