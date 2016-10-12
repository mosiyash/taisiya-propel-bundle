<?php

namespace Taisiya\PropelBundle\Database;

class ExampleForeignKey extends ForeignKey
{
    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'example';
    }
}
