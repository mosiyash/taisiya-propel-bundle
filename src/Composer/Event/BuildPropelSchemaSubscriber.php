<?php

namespace Taisiya\PropelBundle\Composer\Event;

use Composer\EventDispatcher\Event;
use Composer\EventDispatcher\EventSubscriberInterface;
use Taisiya\PropelBundle\Composer\ScriptHandler;
use Taisiya\PropelBundle\Database\AccountTable;
use Taisiya\PropelBundle\Database\DefaultDatabase;
use Taisiya\PropelBundle\Database\Schema;

class BuildPropelSchemaSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            ScriptHandler::EVENT_BUILD_PROPEL_SCHEMA => 'buildPropelSchema',
        ];
    }

    public function buildPropelSchema(Event $event)
    {
        /** @var Schema $schema */
        $schema = $event->getArguments()['schema'];

        $accountTable = $schema->getDatabase(DefaultDatabase::NAME)
            ->getTable(AccountTable::NAME);
    }
}
