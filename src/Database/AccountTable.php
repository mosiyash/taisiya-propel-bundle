<?php

namespace Taisiya\PropelBundle\Database;

final class AccountTable extends AbstractTable
{
    const NAME = 'account';

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
