<?php

namespace ByTIC\Notifications\Notifications;

use ByTIC\Notifications\Messages\Builder\EmailBuilder;

/**
 * Trait HasMessageBuilderTrait
 * @package ByTIC\Notifications\Notifications
 */
trait HasMessageBuilderTrait
{

    /**
     * @param string $type
     * @return mixed
     */
    public function generateMessageBuilder($type = 'mail')
    {
        $class = $this->generateMessageBuilderClass();
        $builder = new $class();
        return $builder;
    }

    /**
     * @return string
     */
    public function generateMailBuilderClass()
    {
        return EmailBuilder::class;
    }

    /**
     * @param string $type
     * @return null
     */
    protected function generateMessageBuilderClass($type = 'mail')
    {
        $method = 'generate' . ucfirst($type) . 'BuilderClass';
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        return null;
    }
}
