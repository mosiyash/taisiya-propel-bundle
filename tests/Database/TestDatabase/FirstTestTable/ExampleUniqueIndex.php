<?php

namespace Taisiya\PropelBundle\Database\TestDatabase\FirstTestTable;

use Taisiya\PropelBundle\Database\Unique;

class ExampleUniqueIndex extends Unique
{
    public static function getName(): string
    {
        return 'example';
    }
}
