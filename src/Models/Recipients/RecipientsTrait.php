<?php

namespace ByTIC\Notifications\Models\Recipients;

use ByTIC\Common\Records\Traits\HasTypes\RecordsTrait;
use Nip\Records\AbstractModels\Record;

/**
 * Trait RecipientsTrait
 * @package ByTIC\Notifications\Models\Recipients
 */
trait RecipientsTrait
{
    use \Nip\Utility\Traits\SingletonTrait;
    use RecordsTrait;

    /**
     * @param $recipient
     * @param $target
     * @param $trigger
     * @return string
     */
    public static function generateNotificationName($recipient, $target, $trigger)
    {
        $name = self::instance()->getRootNamespace();
        $name .= inflector()->pluralize(inflector()->classify($recipient));
        $name .= '\Notifications\\';
        $name .= inflector()->pluralize(inflector()->classify($target)) . '\\';
        $name .= ucfirst($trigger);
        $name .= 'Notification';
        return $name;
    }
    /**
     * Returns the target name from model instance
     *
     * @param Record $model Model Record instance
     *
     * @return string
     */
    public static function modelToRecipientName($model)
    {
        return $model->getManager()->getController();
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function getRecipientManager($name)
    {
        $class = self::getRecipientManagerClass($name);
        return call_user_func([$class, 'instance']);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public static function getRecipientManagerClass($name)
    {
        return inflector()->pluralize(inflector()->classify($name));
    }

    /**
     * @param string $name
     * @return string
     */
    public static function generateRecipientGetterMethod($name)
    {
        return 'get' . inflector()->singularize(inflector()->classify($name));
    }

    /**
     * @return string
     */
    protected function generateTable()
    {
        return 'notification-recipients';
    }

    /**
     * @return string
     */
    public function getTypeItemsDirectory()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'Types';
    }

    /**
     * @return string
     */
    public function getTypeItemsRootNamespace()
    {
        return __NAMESPACE__ . '\Types\\';
    }
}
