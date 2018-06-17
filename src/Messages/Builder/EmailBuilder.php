<?php

namespace ByTIC\Notifications\Messages\Builder;

use ByTIC\Common\Records\Emails\EmailTrait;
use ByTIC\Common\Records\Emails\Builder\ViewBuilder as GenericBuilder;
use ByTIC\Notifications\Notifications\AbstractNotification as Notification;
use ByTIC\Notifications\Notifiable;
use Nip\Records\AbstractModels\Record;
use Nip\Records\Locator\ModelLocator;

/**
 * Class AbstractBuilder
 *
 * @package ByTIC\Notifications\Messages\Builder
 */
abstract class EmailBuilder extends GenericBuilder
{

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
     * @return array
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

    /** @noinspection PhpUnusedParameterInspection
     *
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
     * @param EmailTrait $email
     * @return mixed
     */
    protected function hydrateEmail($email)
    {
        $notifiable = $this->getNotifiable();
        if (method_exists($notifiable, 'routeNotificationFor')) {
            $email->to = $this->getNotifiable()->routeNotificationFor('mail');
        }
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

    /**
     * @inheritdoc
     */
    protected function getEmailsManager()
    {
        return ModelLocator::get('emails');
    }
}
