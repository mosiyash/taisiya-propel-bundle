<?php

namespace Taisiya\PropelBundle\Composer\Event;

use Composer\EventDispatcher\Event;
use Composer\EventDispatcher\EventSubscriberInterface;

/**
 * Interface BuildPropelSchemaSubscriberInterface.
 */
interface BuildPropelSchemaSubscriberInterface extends EventSubscriberInterface
{
    /**
     * @param Event $event
     */
    public function buildPropelSchema(Event $event): void;
}
