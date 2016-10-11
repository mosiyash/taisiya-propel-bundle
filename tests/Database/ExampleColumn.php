<?php

namespace Taisiya\PropelBundle\Database;

class ExampleColumn extends Column
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'example';
    }
}
