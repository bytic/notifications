<?php

namespace ByTIC\Notifications\Models\Topics;

use ByTIC\Notifications\Models\Events\EventTrait as Event;
use ByTIC\Notifications\Models\Recipients\RecipientTrait as Recipient;
use ByTIC\Notifications\Models\Topics\TopicsTrait as Topics;
use Nip\Records\Locator\ModelLocator;
use Nip\Records\RecordManager;

/**
 * Class TopicTrait
 * @package ByTIC\Notifications\Models\Topics
 *
 * @property int $id
 * @property string $target
 * @property string $trigger
 *
 * @method Recipient[] getRecipients()
 * @method save()
 */
class TopicTrait
{
    protected $targetManager = null;

    /**
     * @param $model
     * @param $trigger
     *
     * @return Event
     */
    public function fireEvent($model)
    {
        /** @var Event $event */
        $event = ModelLocator::get('Notifications\Events')->getNew();
        $event->populateFromTopic($this);
        $event->populateFromModel($model);
        $event->save();
        return $event;
    }

    /**
     * @return string
     */
    public function getTrigger()
    {
        return $this->trigger;
    }

    /**
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @return RecordManager
     */
    public function getTargetManager()
    {
        if ($this->targetManager === null) {
            $this->targetManager = $this->generateTargetManager();

        }
        return $this->targetManager;
    }

    /**
     * @return RecordManager
     */
    public function generateTargetManager()
    {
        /** @var Topics $topicsManager */
        $topicsManager = ModelLocator::get('Notifications\Topics');
        return $topicsManager::getTargetManager($this->getTarget());
    }
}
