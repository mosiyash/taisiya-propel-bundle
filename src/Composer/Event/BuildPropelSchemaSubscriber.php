<?php

namespace Taisiya\PropelBundle\Composer\Event;

use Taisiya\PropelBundle\Composer\ScriptHandler;

abstract class BuildPropelSchemaSubscriber implements BuildPropelSchemaSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    final public static function getSubscribedEvents()
    {
        return [
            ScriptHandler::EVENT_BUILD_PROPEL_SCHEMA => 'buildPropelSchema',
        ];
    }
}
