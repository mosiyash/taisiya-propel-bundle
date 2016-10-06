<?php

namespace Taisiya\PropelBundle\Database;

interface ColumnInterface
{
    /**
     * The database name.
     *
     * @return string
     */
    public function getName(): string;
}
