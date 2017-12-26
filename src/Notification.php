<?php

namespace ByTIC\Notifications;

/**
 * Class Notification
 *
 */
class Notification extends AbstractNotification
{

    /**
     * @param $notifiable
     * @return mixed
     */
    public function toMailDb($notifiable)
    {
        $emailBuilder = $this->generateEmailMessage();
        $emailBuilder->setNotifiable($notifiable);
        return $emailBuilder->createEmail();
    }

    /**
     * @inheritdoc
     */
    public function getRecipientName()
    {
        return 'users';
    }
}
