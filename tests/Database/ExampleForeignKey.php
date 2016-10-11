<?php

namespace Taisiya\PropelBundle\Database;

class ExampleForeignKey extends ForeignKey
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'example';
    }
}
