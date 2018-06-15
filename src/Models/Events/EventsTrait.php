<?php

namespace ByTIC\Notifications\Models\Events;

use Nip\Utility\Traits\SingletonTrait;

/**
 * Trait EventsTrait
 * @package ByTIC\Notifications\Models\Events
 */
trait EventsTrait
{
    use \ByTIC\Common\Records\Traits\HasStatus\RecordsTrait;
    use SingletonTrait;

    /**
     * @param array $params
     */
    protected function injectParams(&$params = [])
    {
        $params['order'][] = ['id', 'ASC'];

        /** @noinspection PhpUndefinedClassInspection */
        parent::injectParams($params);
    }

    /**
     * @return string
     */
    protected function generateTable()
    {
        return 'notification-events';
    }

    /**
     * @return string
     */
    public function getStatusItemsDirectory()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'Statuses';
    }

    /**
     * @return string
     */
    public function getStatusItemsRootNamespace()
    {
        return __NAMESPACE__ . '\Statuses\\';
    }
}
