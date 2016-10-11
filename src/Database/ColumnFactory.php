<?php

namespace Taisiya\PropelBundle\Database;

final class ColumnFactory
{
    /**
     * @param Column $column
     * @return Column
     */
    public static function create(Column $column): Column
    {
        return $column;
    }
}
