<?php

namespace Taisiya\PropelBundle\Database\TestDatabase\FirstTestTable;

use Taisiya\PropelBundle\Database\Unique;

class TestUniqueIndex extends Unique
{
    public static function getName(): string
    {
        return 'example';
    }
}
