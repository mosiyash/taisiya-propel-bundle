<?php

namespace Taisiya\PropelBundle\Composer\Event;

use Taisiya\PropelBundle\Composer\ScriptHandler;

abstract class AbstractBuildPropelSchemaSubscriber implements BuildPropelSchemaSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            ScriptHandler::EVENT_BUILD_PROPEL_SCHEMA => 'buildPropelSchema',
        ];
    }
}
