<?php

namespace ByTIC\Notifications\Models\Events;

use ByTIC\Common\Records\Emails\Builder\BuilderAwareTrait;
use ByTIC\Notifications\Exceptions\NotificationModelNotFoundException;
use ByTIC\Notifications\Exceptions\NotificationRecipientModelNotFoundException;
use ByTIC\Notifications\Models\Recipients\RecipientTrait;
use ByTIC\Notifications\Models\Topics\TopicTrait as Topic;
use Nip\Records\AbstractModels\Record;

/**
 * Trait EventsTrait
 * @package ByTIC\Notifications\Models\Events
 *
 * @method Topic getTopic()
 *
 * @property int $id_topic
 * @property int $id_item
 */
trait EventTrait
{
    use \ByTIC\Common\Records\Traits\HasStatus\RecordTrait;

    /**
     * @var null|Record
     */
    protected $model = null;

    /**
     * @return bool
     */
    public function send()
    {
        try {
            $this->sendToAll();
        } catch (NotificationRecipientModelNotFoundException $exception) {
            $this->updateStatus('skipped');

            return;
        } catch (NotificationModelNotFoundException $exception) {
            $this->updateStatus('skipped');

            return;
        }
        $this->updateStatus('sent');

        return true;
    }

    /**
     * @throws NotificationModelNotFoundException
     * @throws NotificationRecipientModelNotFoundException
     */
    protected function sendToAll()
    {
        $recipients = $this->getTopic()->getRecipients();
        foreach ($recipients as $recipient) {
            /** @var RecipientTrait $recipient */
            $recipient->sendEvent($this);
        }
    }

    /**
     * @param Topic $topic
     */
    public function populateFromTopic(Topic $topic)
    {
        $this->id_topic = $topic->id;
    }

    /**
     * @param Record $model
     */
    public function populateFromModel(Record $model)
    {
        $this->model = $model;
        $this->id_item = $model->id;
    }

    /**
     * @return Record|BuilderAwareTrait
     * @throws NotificationModelNotFoundException
     */
    public function getModel()
    {
        if ($this->model === null) {
            $this->initModel();
        }

        return $this->model;
    }

    /**
     * @throws NotificationModelNotFoundException
     */
    public function initModel()
    {
        $item = $this->findModel();
        if ($item instanceof Record) {
            $this->model = $item;

            return;
        }
        throw new NotificationModelNotFoundException('Error finding item [' . $this->id_item . ']');
    }

    /**
     * @return Record
     */
    public function findModel()
    {
        $manager = $this->getTopic()->getTargetManager();

        return $manager->findOne($this->id_item);
    }
}
