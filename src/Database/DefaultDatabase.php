<?php

namespace Taisiya\PropelBundle\Database;

final class DefaultDatabase extends Database
{
    const NAME = 'default';

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
