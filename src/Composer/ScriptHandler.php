<?php

namespace Taisiya\PropelBundle\Composer;

use Composer\Script\Event;
use Taisiya\CoreBundle\Composer\ScriptHandler as CoreScriptHandler;
use Taisiya\PropelBundle\Database\AccountTable;
use Taisiya\PropelBundle\Database\ColumnFactory;
use Taisiya\PropelBundle\Database\DatabaseFactory;
use Taisiya\PropelBundle\Database\DefaultDatabase;
use Taisiya\PropelBundle\Database\SchemaFactory;
use Taisiya\PropelBundle\Database\TableFactory;

defined('TAISIYA_ROOT') || define('TAISIYA_ROOT', dirname(dirname(__DIR__)));

class ScriptHandler extends CoreScriptHandler
{
    /**
     * @param Event $event
     */
    public static function createPropelConfigFile(Event $event): void
    {
        $settings = require TAISIYA_ROOT.'/app/config/settings.php';

        if (empty($settings['propel'])) {
            $event->getIO()->writeError('  - <error>propel configuration is empty</error>');
        } elseif (!file_put_contents(TAISIYA_ROOT.'/propel.php', "<?php\n\nreturn ".var_export($settings['propel'], true).";\n")) {
            $event->getIO()->writeError('  - <error>couldn\'t write a file: '.TAISIYA_ROOT.'/propel.php</error>');
        } else {
            $event->getIO()->write('  - <info>writed to '.TAISIYA_ROOT.'/propel.php</info>');
        }
    }

    /**
     * @param Event $event
     */
    public static function createSchemaFile(Event $event): void
    {
        $schema = SchemaFactory::create()
            ->addDatabase(
                DatabaseFactory::create(DefaultDatabase::class)
                    ->addTable(
                        TableFactory::create(AccountTable::class)
                            ->addColumn(
                                ColumnFactory::create(AccountTable\IdColumn::class)
                            )
                    )
            );

        exit(var_dump($schema));
    }
}
