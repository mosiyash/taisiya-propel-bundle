<?php

namespace Taisiya\PropelBundle\Database\TestDatabase;

use Taisiya\PropelBundle\Database\Database;

class TestDatabase extends Database
{
    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'example';
    }
}
