<?php

namespace Taisiya\PropelBundle\Database\TestDatabase\FirstTestTable;

use Taisiya\PropelBundle\Database\Column;

class ThirdColumn extends Column
{
    public static function getName(): string
    {
        return 'third';
    }
}
