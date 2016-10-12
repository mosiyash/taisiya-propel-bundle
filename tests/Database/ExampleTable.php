<?php

namespace Taisiya\PropelBundle\Database;

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
