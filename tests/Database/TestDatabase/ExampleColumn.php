<?php

namespace Taisiya\PropelBundle\Database\TestDatabase;

use Taisiya\PropelBundle\Database\Column;

class ExampleColumn extends Column
{
    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'example';
    }
}
