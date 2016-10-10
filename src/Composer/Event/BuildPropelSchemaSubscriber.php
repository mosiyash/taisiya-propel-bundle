<?php

namespace Taisiya\PropelBundle\Composer\Event;

use Composer\EventDispatcher\Event;
use Taisiya\PropelBundle\Database\Schema;

class BuildPropelSchemaSubscriber extends AbstractBuildPropelSchemaSubscriber
{
    /**
     * {@inheritdoc}
     */
    public function buildPropelSchema(Event $event): void
    {
        /** @var Schema $schema */
        $schema = $event->getArguments()['schema'];
    }
}
