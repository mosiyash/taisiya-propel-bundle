<?php

namespace Taisiya\PropelBundle\Database\ExampleTable;

use Taisiya\PropelBundle\Database\Column;

class IdColumn extends Column
{
    public static function getName(): string
    {
        return 'id';
    }
}
