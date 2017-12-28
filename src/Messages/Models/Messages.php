<?php

namespace Galantom\Models\Notifications\Messages;

use Galantom\Models\Notifications\Recipients\Recipient;
use Galantom\Models\Notifications\Recipients\Recipients;
use Galantom\Models\Notifications\Topics\Topic;

/**
 * Class Messages
 *
 * @package Galantom\Models\Notifications\Messages
 * @method Message findOneByParams
 */
class Messages extends \Records
{
    use \Nip\Utility\Traits\SingletonTrait;

    protected $table = 'notification-messages';

    /**
     * @param string|Topic $topic
     * @param string|Recipient $recipient
     * @param string $channel
     * @return Message
     */
    public static function getGlobal($topic, $recipient, $channel)
    {
        $params['where'] = [];
        $params['where'][] = ['`id_topic` = ?', self::formatTopic($topic)];
        $params['where'][] = [
            '`recipient` = ?',
            is_string($recipient) ? $recipient : Recipients::modelToRecipientName($recipient)
        ];
        $params['where'][] = ['`channel` = ?', $channel];

        return self::instance()->findOneByParams($params);
    }

    /**
     * @param int|string|Topic $topic
     * @return int
     */
    public static function formatTopic($topic)
    {
        if (is_int($topic)) {
            return $topic;
        }
        if (is_string($topic)) {
            return intval($topic);
        }
        return $topic->id;
    }
}