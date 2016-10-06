<?php

namespace Taisiya\PropelBundle\Database;

final class TableFactory
{
    /**
     * @param $tableClass
     * @return TableInterface
     * @throws \InvalidArgumentException
     */
    public static function create($tableClass): TableInterface
    {
        $obj = new $tableClass;

        if (!$obj instanceof TableInterface) {
            throw new \InvalidArgumentException('Table class must be instance of '.TableInterface::class);
        }

        return $obj;
    }
}
