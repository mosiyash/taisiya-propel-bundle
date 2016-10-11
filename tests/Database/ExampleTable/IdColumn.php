<?php

namespace Taisiya\PropelBundle\Database\ExampleTable;

use Taisiya\PropelBundle\Database\Column;

class IdColumn extends Column
{
    public function getName(): string
    {
        return 'id';
    }
}
