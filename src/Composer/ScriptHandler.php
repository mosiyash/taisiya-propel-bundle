<?php

namespace Taisiya\PropelBundle\Composer;

use Composer\Script\Event;
use Taisiya\CoreBundle\Composer\ScriptHandler as CoreScriptHandler;
use Taisiya\PropelBundle\Database\AccountTable;
use Taisiya\PropelBundle\Database\ColumnFactory;
use Taisiya\PropelBundle\Database\DatabaseFactory;
use Taisiya\PropelBundle\Database\DefaultDatabase;
use Taisiya\PropelBundle\Database\Schema;
use Taisiya\PropelBundle\Database\TableFactory;

defined('ROOT_DIR') || define('ROOT_DIR', dirname(dirname(__DIR__)));

class ScriptHandler extends CoreScriptHandler
{
    public static function createPropelConfigFile(Event $event): void
    {
        $settings = require ROOT_DIR.'/app/config/settings.php';

        if (empty($settings['propel'])) {
            $event->getIO()->writeError('  - <error>propel configuration is empty</error>');
        } elseif (!file_put_contents(ROOT_DIR.'/propel.php', "<?php\n\nreturn ".var_export($settings['propel'], true).";\n")) {
            $event->getIO()->writeError('  - <error>couldn\'t write a file: '.ROOT_DIR.'/propel.php</error>');
        } else {
            $event->getIO()->write('  - <info>writed to '.ROOT_DIR.'/propel.php</info>');
        }
    }

    public static function createSchemaFile(Event $event): void
    {
        $database = DatabaseFactory::create(DefaultDatabase::class)
            ->addTable(
                TableFactory::create(AccountTable::class)
                    ->addColumn(
                        ColumnFactory::create(AccountTable\IdColumn::class)
                    )
            );


        $schema = new Schema();
        $schema->addDatabase($database);
    }
}
