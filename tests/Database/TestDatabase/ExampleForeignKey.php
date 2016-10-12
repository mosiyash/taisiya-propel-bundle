<?php

namespace Taisiya\PropelBundle\Database\TestDatabase;

use Taisiya\PropelBundle\Database\ForeignKey;

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
