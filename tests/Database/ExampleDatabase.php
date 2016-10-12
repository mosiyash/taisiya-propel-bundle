<?php

namespace Taisiya\PropelBundle\Database;

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
