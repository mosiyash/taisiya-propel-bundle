<?php

namespace Taisiya\PropelBundle\Database;

class ExampleForeignTable extends Table
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'example_foreign';
    }
}
