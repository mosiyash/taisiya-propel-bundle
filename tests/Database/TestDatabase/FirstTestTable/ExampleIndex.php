<?php

namespace Taisiya\PropelBundle\Database\TestDatabase\FirstTestTable;

use Taisiya\PropelBundle\Database\Index;

class ExampleIndex extends Index
{
    public static function getName(): string
    {
        return 'example';
    }
}
