<?php

namespace Taisiya\PropelBundle\Database\TestDatabase;

use Taisiya\PropelBundle\Database\Table;

class ExampleTable extends Table
{
    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'example';
    }
}
