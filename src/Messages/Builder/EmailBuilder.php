<?php

namespace Galantom\Models\Notifications\Messages\Builder;

use ByTIC\Common\Records\Emails\EmailTrait;
use Email;
use Galantom\Models\Emails\Builder\GenericBuilder;
use Galantom\Models\Notifications\AbstractNotification as Notification;
use Galantom\Models\Notifications\Messages\Message;
use Galantom\Models\Notifications\Notifiable;
use Record;

/**
 * Class AbstractBuilder
 *
 * @package Galantom\Models\Notifications\Messages\Builder
 */
class EmailBuilder extends GenericBuilder
{
    /**
     * @var Notification
     */
    protected $notification = null;

    /**
     * Model of notifiable trait
     *
     * @var Record|Notifiable
     */
    protected $notifiable = null;

    /**
     * @var array|null
     */
    protected $mergeFields = null;

    /**
     * Returns the email subject
     *
     * @return string
     */
    public function generateEmailSubject()
    {
        return $this->getNotificationMessage()->getSubject();
    }

    /**
     * @return Message
     */
    protected function getNotificationMessage()
    {
        return $this->getNotification()->getNotificationMessage();
    }

    /**
     * @return Notification
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * Set the Notification instance
     *
     * @param Notification $notification Notification instance
     *
     * @return void
     */
    public function setNotification($notification)
    {
        $this->notification = $notification;
    }

    /**
     * @inheritdoc
     */
    public function compile()
    {
        parent::compile();
        $this->compileMergeFields();
    }

    public function compileMergeFields()
    {
        $mergeFields = $this->getMergeFields();
        foreach ($mergeFields as $group => $fields) {
            foreach ($fields as $field) {
                $this->setMergeTag($field, $this->getMergeFieldValue($field));
            }
        }
    }

    /**
     * @return []
     */
    public function getMergeFields()
    {
        if ($this->mergeFields === null) {
            $this->mergeFields = $this->generateMergeFields();
        }

        return $this->mergeFields;
    }

    /**
     * Generates the MergeFields array
     *
     * @return array
     */
    public function generateMergeFields()
    {
        return [];
    }

    /**
     * Get the MergeField value
     *
     * @param string $field Field Name
     *
     * @return null
     */
    public function getMergeFieldValue($field)
    {
        return null;
    }

    /**
     * Returns the email content
     *
     * @return null|string
     */
    protected function generateEmailContent()
    {
        return $this->getNotificationMessage()->getContent();
    }

    /**
     * @param Email|EmailTrait $email
     * @return mixed
     */
    protected function hydrateEmail($email)
    {
        $email->to = $this->getNotifiable()->routeNotificationFor('mail');
        return parent::hydrateEmail($email);
    }

    /**
     * Set the Notifiable instance
     *
     * @return Record|Notifiable
     */
    public function getNotifiable()
    {
        return $this->notifiable;
    }

    /**
     * Set the Notifiable instance
     *
     * @param Record $notifiable Notifiable record
     *
     * @return void
     */
    public function setNotifiable($notifiable)
    {
        $this->notifiable = $notifiable;
    }
}
