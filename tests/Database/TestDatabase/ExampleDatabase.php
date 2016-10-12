<?php

namespace Taisiya\PropelBundle\Database\TestDatabase;

use Taisiya\PropelBundle\Database\Database;

class ExampleDatabase extends Database
{
    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'example';
    }
}
