<?php

namespace Taisiya\PropelBundle\Database;

interface IndexInterface
{
    /**
     * The index name.
     * @return string
     */
    public static function getName(): string;
}
