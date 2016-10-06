<?php

namespace Taisiya\PropelBundle\Database\AccountTable;

use Taisiya\PropelBundle\Database\AbstractColumn;

class IdColumn extends AbstractColumn
{
    const NAME = 'id';

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
