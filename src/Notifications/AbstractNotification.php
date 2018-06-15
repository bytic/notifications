<?php

namespace ByTIC\Notifications\Notifications;

use ByTIC\Notifications\Exceptions\NotificationModelNotFoundException;
use ByTIC\Notifications\Models\Events\EventTrait as Event;
use ByTIC\Notifications\Messages\Builder\EmailBuilder;
use ByTIC\Notifications\Models\Messages\MessageTrait as Message;
use ByTIC\Notifications\Models\Messages\MessagesTrait as Messages;
use Nip\Records\AbstractModels\Record;
use Nip\Records\Locator\ModelLocator;

/**
 * Class AbstractNotification
 * @package ByTIC\Notifications
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
    public function __construct($event = null)
    {
        if ($event) {
            $this->setEvent($event);
        }
    }

    /** @noinspection PhpUnusedParameterInspection
     *
     * @param Record $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['emailDb'];
    }

    /**
     * @return EmailBuilder
     * @throws NotificationModelNotFoundException
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
     * @throws NotificationModelNotFoundException
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
        /** @var Messages $messages */
        $messages = ModelLocator::get('Notifications\Messages');
        return $messages::getGlobal(
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
