<?php

namespace Taisiya\PropelBundle\Database;

final class DefaultDatabase extends Database
{
    /**
     * {@inheritdoc}
     */
    public STATIC function getName(): string
    {
        return 'default';
    }
}
