<?php

namespace Galantom\Models\Notifications\Messages;

use Galantom\Models\Notifications\Recipients\Recipient;
use Galantom\Models\Notifications\Recipients\Recipients;
use Record;

/**
 * Class Topic
 *
 * @package Galantom\Models\Notifications\Topics
 *
 * @property int $id_topic
 * @property string $recipient
 * @property string $channel
 * @property string $subject
 * @property string $content
 */
class Message extends Record
{

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @return false|Recipient
     */
    public function getNotificationRecipient()
    {
        $params = [];
        $params['where'][] = ['`id_topic` = ?', $this->id_topic];
        $params['where'][] = ['`recipient` = ?', $this->recipient];
        return Recipients::instance()->findOneByParams($params);
    }
}
