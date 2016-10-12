<?php

namespace Taisiya\PropelBundle\Database;

final class DefaultDatabase extends Database
{
    /**
     * {@inheritdoc}
     */
    public static function getName(): string
    {
        return 'default';
    }
}
