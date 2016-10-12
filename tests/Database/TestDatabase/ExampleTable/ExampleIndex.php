<?php

namespace Taisiya\PropelBundle\Database\TestDatabase\ExampleTable;

use Taisiya\PropelBundle\Database\Index;

class ExampleIndex extends Index
{
    public static function getName(): string
    {
        return 'example';
    }
}
