<?php

namespace Taisiya\PropelBundle\Composer;

use Composer\Script\Event;
use Taisiya\CoreBundle\Composer\ScriptHandler as CoreScriptHandler;

defined('ROOT_DIR') || define('ROOT_DIR', dirname(dirname(__DIR__)));

class ScriptHandler extends CoreScriptHandler
{
    public static function generateXMLSchema(Event $event): void
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
}
