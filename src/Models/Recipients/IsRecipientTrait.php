<?php

namespace ByTIC\Notifications\Models\Recipients;

use ByTIC\Notifications\Notifiable;

/**
 * Trait IsRecipientTrait
 * @package ByTIC\Notifications\Models\Recipients
 */
trait IsRecipientTrait
{

    /**
     * @return Notifiable[]
     */
    public function generateNotifiables()
    {
        return [$this];
    }
}
