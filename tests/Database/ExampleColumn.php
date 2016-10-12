<?php

namespace Taisiya\PropelBundle\Database;

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
