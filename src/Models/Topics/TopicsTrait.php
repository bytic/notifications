<?php

namespace ByTIC\Notifications\Models\Topics;

use ByTIC\Notifications\Models\Events\EventTrait as Event;
use Nip\Records\AbstractModels\Record;
use ByTIC\Notifications\Models\Topics\TopicTrait as Topic;

/**
 * Class TopicsTrait
 * @package ByTIC\Notifications\Models\Topics
 *
 * @method findOneByParams($params)
 */
trait TopicsTrait
{
    use \Nip\Utility\Traits\SingletonTrait;


    /**
     * Fire a notification event
     *
     * @param Record $model Model Record instance
     * @param string $trigger Trigger name
     *
     * @return bool|Event
     */
    public static function fireEvent($model, $trigger)
    {
        $target = self::modelToTargetName($model);
        $topic = self::findByTargetTrigger($target, $trigger);
        if ($topic) {
            return $topic->fireEvent($model);
        }
        return false;
    }

    /**
     * @param $target
     * @param $trigger
     * @return false|Topic
     */
    public static function findByTargetTrigger($target, $trigger)
    {
        $self = self::instance();
        $params = [
            'where' => [
                ['`target` = ?', $target],
                ['`trigger` = ?', $trigger]
            ]
        ];
        return $self->findOneByParams($params);
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function getTargetManager($name)
    {
        $class = self::getTargetManagerClass($name);
        return call_user_func([$class, 'instance']);
    }

    /**
     * Returns the target name from model instance
     *
     * @param Record $model Model Record instance
     *
     * @return string
     */
    public static function modelToTargetName($model)
    {
        return inflector()->singularize($model->getManager()->getTable());
    }

    /**
     * @return string
     */
    protected function generateTable()
    {
        return 'notification-topics';
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public static function getTargetManagerClass($name)
    {
        return inflector()->pluralize(inflector()->classify($name));
    }
}
