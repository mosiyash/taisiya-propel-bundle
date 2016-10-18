<?php

namespace Taisiya\PropelBundle\Composer;

use Composer\EventDispatcher\Event;
use PhpParser\Node;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\ParserFactory;
use Symfony\Component\Finder\Finder;
use Taisiya\CoreBundle\Composer\ScriptHandler as CoreScriptHandler;
use Taisiya\PropelBundle\Database\Schema;

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
        $dispatcher             = $event->getComposer()->getEventDispatcher();
        $schema                 = new Schema();
        $buildPropelSchemaEvent = new Event(self::EVENT_BUILD_PROPEL_SCHEMA, ['schema' => $schema]);

        $finder = (new Finder())
            ->in([TAISIYA_ROOT.'/vendor', TAISIYA_ROOT.'/src'])
            ->name('BuildPropelSchemaSubscriber.php');

        foreach ($finder as $file) {
            $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);

            $stmts = $parser->parse(file_get_contents($file->getPathname()));
            if ($stmts === null) {
                continue;
            }

            /** @var Namespace_ $namespace */
            $namespace = self::findNodeByInstanceType($stmts, Namespace_::class);
            if ($namespace === null) {
                continue;
            }

            /** @var Node\Stmt\Class_ $class */
            $class = self::findNodeByInstanceType($namespace->stmts, Node\Stmt\Class_::class);
            if ($class->name !== 'BuildPropelSchemaSubscriber' || $class->isAbstract()) {
                continue;
            }

            $fullClassName = implode('\\', $namespace->name->parts).'\\'.$class->name;
            $dispatcher->addSubscriber(new $fullClassName());

            $event->getIO()->write('  - added subscriber <info>'.$fullClassName.'</info>');
        }

        $dispatcher->dispatch(self::EVENT_BUILD_PROPEL_SCHEMA, $buildPropelSchemaEvent);

        if (!file_put_contents(TAISIYA_ROOT.'/schema.xml', $schema->generateOutputXml())) {
            throw new \RuntimeException('Couldn\'t save schema to '.TAISIYA_ROOT.'/schema.xml');
        } else {
            $event->getIO()->write('  - saved schema to <info>'.TAISIYA_ROOT.'/schema.xml</info>');
        }
    }

    /**
     * @param array  $stmts
     * @param string $classname
     *
     * @return Node|null
     */
    private static function findNodeByInstanceType(array $stmts, $classname)
    {
        foreach ($stmts as $node) {
            if ($node instanceof $classname) {
                return $node;
            }
        }

        return null;
    }
}
