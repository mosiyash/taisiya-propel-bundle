<?php

namespace Taisiya\PropelBundle\Database\TestDatabase\ExampleForeignTable;

use Taisiya\PropelBundle\Database\Column;

class ForeignIdColumn extends Column
{
    public static function getName(): string
    {
        return 'foreign_id';
    }
}
