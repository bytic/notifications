<?php

namespace ByTIC\Notifications\Notifications;

use Nip\Records\AbstractModels\Record;

/**
 * Class AbstractNotification
 * @package ByTIC\Notifications
 */
abstract class AbstractNotification
{

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
     * @param $notifiable
     * @return mixed
     */
    abstract public function toMailDb($notifiable);
}
