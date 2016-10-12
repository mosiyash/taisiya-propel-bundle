<?php

namespace Taisiya\PropelBundle\Database\TestDatabase\ExampleTable;

use Taisiya\PropelBundle\Database\Column;

class SecondColumn extends Column
{
    public static function getName(): string
    {
        return 'second';
    }
}
