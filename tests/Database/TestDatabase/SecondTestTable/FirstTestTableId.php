<?php

namespace Taisiya\PropelBundle\Database\TestDatabase\SecondTestTable;

use Taisiya\PropelBundle\Database\Column;

class FirstTestTableId extends Column
{
    public static function getName(): string
    {
        return 'fid';
    }
}
