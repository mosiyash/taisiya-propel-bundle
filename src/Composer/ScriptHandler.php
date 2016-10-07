<?php

namespace Taisiya\PropelBundle\Composer;

use Composer\EventDispatcher\Event;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use Symfony\Component\Finder\Finder;
use Taisiya\CoreBundle\Composer\ScriptHandler as CoreScriptHandler;
use Taisiya\PropelBundle\Composer\Event\BuildPropelSchemaSubscriber;
use Taisiya\PropelBundle\Database\AccountTable;
use Taisiya\PropelBundle\Database\ColumnFactory;
use Taisiya\PropelBundle\Database\DatabaseFactory;
use Taisiya\PropelBundle\Database\DefaultDatabase;
use Taisiya\PropelBundle\Database\SchemaFactory;
use Taisiya\PropelBundle\Database\TableFactory;

defined('TAISIYA_ROOT') || define('TAISIYA_ROOT', dirname(dirname(__DIR__)));

class ScriptHandler extends CoreScriptHandler
{
    const EVENT_BUILD_PROPEL_SCHEMA = 'composer.build_propel_schema';

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
    public static function buildPropelSchema(Event $event): void
    {
        $dispatcher = $event->getComposer()->getEventDispatcher();
        $schema = SchemaFactory::create()->addDatabase(DatabaseFactory::create(DefaultDatabase::class));
        $buildPropelSchemaEvent = new Event(self::EVENT_BUILD_PROPEL_SCHEMA, ['schema' => $schema]);

        $finder = (new Finder())
            ->in([TAISIYA_ROOT.'/vendor', TAISIYA_ROOT.'/src'])
            ->name('BuildPropelSchemaSubscriber.php');

        foreach ($finder as $file) {
            $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
            $traverser = new NodeTraverser();
            $stmts = $parser->parse(file_get_contents($file->getPathname()));

        }
        exit(print_r($files));

        // $dispatcher->addSubscriber(new BuildPropelSchemaSubscriber());

        $dispatcher->dispatch(self::EVENT_BUILD_PROPEL_SCHEMA, $buildPropelSchemaEvent);
    }
}
